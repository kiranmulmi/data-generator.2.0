<?php
/**
 * Created by PhpStorm.
 * User: Kiran
 * Date: 11/1/2016
 * Time: 9:05 PM
 */

namespace App\Generator;


class GeneratorController
{
    private $fakecompany;
    private $fakename;
    private $fakestreet;
    private $fake_long_text;
    private $fake_short_text;
    private $dummy_city;
    private $auto_inc;

    public function __construct()
    {
        $this->fakecompany = file('Dictionary/company');
        $this->fakename = file('Dictionary/name');
        $this->fakestreet = file('Dictionary/street');
        $this->fake_long_text = file('Dictionary/long-text');
        $this->fake_short_text = file('Dictionary/short-text');
        $this->dummy_city = file('Dictionary/city');
        $this->auto_inc = 1;
    }

    public function index()
    {
        $generatorRepo = new GeneratorRepository();

        $decoded_data = json_decode($_POST["json"]);
        $no_of_rows = $_POST["no_of_rows"];
        $table = $_POST["table"];
        $preview_or_generate = $_POST["preview_or_generate"];
        $database = $_POST["database"];
        $batch_size = $_POST["batch_size"];

        /*sql generate */
        if ($preview_or_generate == "generate") {
            $connection = $generatorRepo->GetConnectedServerConnection($database);
            $status = "success";

            $sql = "INSERT INTO `$table` ( ";
            $coma = "";
            foreach ($decoded_data as $item) {
                if ($item->hidden_column_key != "PRI") {
                    $sql .= $coma . "`" . $item->column . "`";
                    $coma = ",";
                }
            }
            $sql .= ") VALUES ";
            for ($i = 0; $i < $no_of_rows; $i++) {
                $cc = "";
                $sub_sql = "";
                for ($j = 0; $j < $batch_size; $j++) {
                    $coma = "";
                    $sub_sql .= $cc." ( ";
                    foreach ($decoded_data as $item) {
                        if ($item->hidden_column_key != "PRI") {
                            $sub_sql .= $coma . '"' . $this->randomize($item->selected_data_type, $item->data_type, $item->options) . '"';
                            $coma = ",";
                            $cc = ",";
                        }
                    }
                    $sub_sql .= ")";

                }
                $exec = $sql.$sub_sql;
                //echo "<pre>".$exec."</pre>";
                $status = $connection->query($exec);
                if($status) {
                    echo "success";
                } else {
                    echo "error";
                }

            }

        } elseif ($preview_or_generate == "preview") {
            $return_data = array();
            for ($i = 0; $i < 5; $i++) {
                $row_data = array();
                foreach ($decoded_data as $item) {
                    $row_data[] = $this->randomize($item->selected_data_type, $item->data_type, $item->options);
                }
                $return_data[] = $row_data;
            }
            echo json_encode($return_data);
        }
    }

    public function randomize($selected_data_type, $data_type, $options)
    {
        $O_to_9 = "0123456789";
        $a_to_z = "abcdefghijklmnopqrstuvwxyz";

        $domain = array("com", "net", "gov", "org", "edu", "biz", "info");

        $return_text = "";
        if ($selected_data_type == "name") {
            $options = explode("|", $options);
            $count = count($this->fakename);
            $key1 = rand(0, $count - 1);
            $key2 = rand(0, $count - 1);
            $first_name = explode(",", $this->fakename[$key1]);
            $last_name = explode(",", $this->fakename[$key2]);
            if (isset($options[0]) && !isset($options[1])) {
                $return_text = $first_name[0];
                if ($options[0] == "l" || $options[0] == "m") $return_text = $last_name[0];
            } elseif (isset($options[0]) && isset($options[1]) && !isset($options[2])) {
                $return_text .= $first_name[0] . " " . $last_name[1];
            } elseif (isset($options[0]) && isset($options[1]) && isset($options[2])) {
                $return_text .= $first_name[0] . " " . $last_name[0] . " " . $last_name[1];
            }
        } elseif ($selected_data_type == "phone") {
            $options = explode("|", $options);
            $prefixArray = explode(",", $options[0]);
            $key = rand(0, count($prefixArray) - 1);
            $digit = $options[1];
            $num = $prefixArray[$key] . substr(str_shuffle($O_to_9 . $O_to_9), 0, $digit - strlen($prefixArray[$key]));
            $return_text = $num;
        } elseif ($selected_data_type == "email") {
            $name_key = rand(0, count($this->fakename)-1);
            $name = explode(",",$this->fakename[$name_key]);
            $return_text = strtolower($name[0]).substr(str_shuffle($O_to_9), 0, rand(4, 6))."@".substr(str_shuffle($a_to_z),0, rand(4,6)).".".$domain[rand(0,count($domain)-1)];
            /*$key = rand(0, count($domain) - 1);
            $email = substr(str_shuffle($a_to_z), 0, rand(4, 10)) . substr(str_shuffle($O_to_9), 0, rand(4, 6)) . "@" . substr(str_shuffle($a_to_z), 0, rand(4, 10)) . "." . $domain[$key];
            return $email;*/
        } elseif ($selected_data_type == "date") {
            $dateArr = explode("|", $options);
            $min = strtotime($dateArr[0]);
            $max = strtotime($dateArr[1]);
            $val = rand($min, $max);
            $return_text = date('Y-m-d H:i:s', $val);;
        } elseif ($selected_data_type == "street") {
            $key = rand(0, count($this->fakestreet) - 1);
            $return_text = $this->fakestreet[$key];
        } elseif ($selected_data_type == "username") {
            $return_text = substr(str_shuffle($a_to_z), 0, rand(4, 10)) . substr(str_shuffle($O_to_9), 0, rand(4, 6));
        } elseif ($selected_data_type == "password") {
            $password = "admin";
            $encryption_salt = "8f5d0eae5947135741cd0aef3teg6eb2";
            $encrypted = hash("sha256", $encryption_salt . $password);
            $return_text = $encrypted;
        } elseif ($selected_data_type == "short_text") {
            $key = rand(0, count($this->fake_short_text) - 1);
            $return_text = $this->fake_short_text[$key];
        } elseif ($selected_data_type == "long_text") {
            $key = rand(0, count($this->fake_long_text) - 1);
            $return_text = $this->fake_long_text[$key];
        } elseif ($selected_data_type == "number") {
            $numArr = explode("|", $options);
            $min = $numArr[0];
            $max = $numArr[1];
            $return_text = rand($min, $max);
        } elseif ($selected_data_type == "custom_list") {
            $list = explode("|", $options);
            $key = rand(0, count($list) - 1);
            $return_text = $list[$key];
        } elseif ($selected_data_type == "auto_increment") {
            $return_text = $this->auto_inc++;
        } elseif ($selected_data_type == "city" || $selected_data_type == "region") {
            $key = rand(0, count($this->dummy_city) - 1);
            $return_text = $this->dummy_city[$key];
        } elseif ($selected_data_type == "postal") {
            $return_text = rand(100, 1000);
        } elseif ($selected_data_type == "country") {
            global $dummy_country;
            $key = rand(0, count($dummy_country) - 1);
            $return_text = $dummy_country[$key];
        } elseif ($selected_data_type == "lat") {
            $radius = 100;
            $angle = deg2rad(mt_rand(0, 359));
            $pointRadius = mt_rand(0, $radius);
            $return_text = sin($angle) * $pointRadius;
        } elseif ($selected_data_type == "lng") {
            $radius = 100;
            $angle = deg2rad(mt_rand(0, 359));
            $pointRadius = mt_rand(0, $radius);
            $return_text = cos($angle) * $pointRadius;
        } elseif ($selected_data_type == "url") {
            $key = rand(0, count($domain) - 1);
            $url = "http://www." . substr(str_shuffle($a_to_z), 0, rand(3, 5)) . "." . $domain[$key];
            $return_text = $url;
        }

        return $return_text;
    }

}