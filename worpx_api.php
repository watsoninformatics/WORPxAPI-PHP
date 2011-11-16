<?php

class worpx_api {

    function __construct() {
        $this->batch_open = false;
        $this->request_open = false;
        $this->last_error_code = null;
        $this->last_message = null;
    }

    function setServer($server_url) {
        $this->server_url = $server_url;
    }

    function getServer() {
        return $this->server_url;
    }

    function setToken($token) {
        $this->token = $token;
    }

    function getToken() {
        return $this->token;
    }

    function getLastMessage() {
        return $this->last_message;
    }

    function getLastErrorCode() {
        return $this->last_error_code;
    }

    function addTemplate($path_to_file, $document_name, $document_description) {
        $document_name = urlencode($document_name);
        $document_description = urlencode($document_description);
        $url = "{$this->server_url}/meta.php?mode=template&doc_name={$document_name}&doc_desc={$document_description}&token={$this->token}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $post_array = array(
            "template" => "@{$path_to_file}",
            "upload" => "Upload"
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array);
        $response = curl_exec($ch);
        @$response_xml = simplexml_load_string($response);
        if ($response_xml == false) {
            $this->last_error_code = 999;
            return array(
                "error" => true,
                "message" => $this->last_message = "Unusable response from server.  Check if server path is correct.",
                "document_id" => null
            );
        } else {
            if ($response_xml->error_code == 0) {
                $this->last_error_code = $response_xml->error_code;
                return array(
                    "error" => false,
                    "message" => $this->last_message = $response_xml->message,
                    "document_id" => $response_xml->doc_id
                );
            } else {
                $this->last_error_code = $response_xml->error_code;
                return array(
                    "error" => true,
                    "message" => $this->last_message = $response_xml->message,
                    "document_id" => null
                );
            }
        }
        unset($response_xml);
        unset($url);
        unset($response);
    }

    function updateTemplate($path_to_file, $document_id) {
        $url = "{$this->server_url}/meta.php?mode=template&doc_id={$document_id}&token={$this->token}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $post_array = array(
            "template" => "@{$path_to_file}",
            "upload" => "Upload"
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array);
        $response = curl_exec($ch);
        @$response_xml = simplexml_load_string($response);
        if ($response_xml == false) {
            $this->last_error_code = 999;
            return array(
                "error" => true,
                "message" => $this->last_message = "Unusable response from server.  Check if server path is correct."
            );
        } else {
            if ($response_xml->error_code == 0) {
                $this->last_error_code = $response_xml->error_code;
                return array(
                    "error" => false,
                    "message" => $this->last_message = $response_xml->message
                );
            } else {
                $this->last_error_code = $response_xml->error_code;
                return array(
                    "error" => true,
                    "message" => $this->last_message = $response_xml->message
                );
            }
        }
        unset($response_xml);
        unset($url);
        unset($response);
    }

    function deleteTemplate($document_id) {
        $document_id = urlencode($document_id);
        $url = "{$this->server_url}/meta.php?mode=delete_template&doc_id={$document_id}&token={$this->token}";
        $response = file_get_contents($url);
        @$response_xml = simplexml_load_string($response);
        if ($response_xml == false) {
            $this->last_error_code = 999;
            return array(
                "error" => true,
                "message" => $this->last_message = "Unusable response from server.  Check if server path is correct.",
                "document_id" => null
            );
        } else {
            $this->last_error_code = $response_xml->error_code;
            if ($response_xml->error_code == 0) {
                return array(
                    "error" => false,
                    "message" => $this->last_message = $response_xml->message,
                    "document_id" => $response_xml->doc_id
                );
            } else {
                return array(
                    "error" => true,
                    "message" => $this->last_message = $response_xml->message,
                    "document_id" => null
                );
            }
        }
        unset($response_xml);
        unset($url);
        unset($response);
    }

    function updateTemplateName($document_id, $new_name) {
        $document_id = urlencode($document_id);
        $new_name = urlencode($new_name);
        $url = "{$this->server_url}/meta.php?mode=name_template&doc_id={$document_id}&doc_name={$new_name}&token={$this->token}";
        $response = file_get_contents($url);
        @$response_xml = simplexml_load_string($response);
        if ($response_xml == false) {
            $this->last_error_code = 999;
            return array(
                "error" => true,
                "message" => $this->last_message = "Unusable response from server.  Check if server path is correct.",
                "document_id" => null
            );
        } else {
            $this->last_error_code = $response_xml->error_code;
            if ($response_xml->error_code == 0) {
                return array(
                    "error" => false,
                    "message" => $this->last_message = $response_xml->message,
                    "document_id" => $response_xml->doc_id
                );
            } else {
                return array(
                    "error" => true,
                    "message" => $this->last_message = $response_xml->message,
                    "document_id" => null
                );
            }
        }
        unset($response_xml);
        unset($url);
        unset($response);
    }

    function updateTemplateDescription($document_id, $new_description) {
        $document_id = urlencode($document_id);
        $new_description = urlencode($new_description);
        $url = "{$this->server_url}/meta.php?mode=name_template&doc_id={$document_id}&doc_desc={$new_description}&token={$this->token}";
        $response = file_get_contents($url);
        @$response_xml = simplexml_load_string($response);
        if ($response_xml == false) {
            $this->last_error_code = 999;
            return array(
                "error" => true,
                "message" => $this->last_message = "Unusable response from server.  Check if server path is correct.",
                "document_id" => null
            );
        } else {
            $this->last_error_code = $response_xml->error_code;
            if ($response_xml->error_code == 0) {
                return array(
                    "error" => false,
                    "message" => $this->last_message = $response_xml->message,
                    "document_id" => $response_xml->doc_id
                );
            } else {
                return array(
                    "error" => true,
                    "message" => $this->last_message = $response_xml->message,
                    "document_id" => null
                );
            }
        }
        unset($response_xml);
        unset($url);
        unset($response);
    }

    function getTemplateVariables($document_id) {
        @$variable_xml = simplexml_load_string(file_get_contents("{$this->server_url}/meta.php?mode=variables&doc_id={$document_id}&token={$this->token}"));
        if ($variable_xml) {
            $this->last_error_code = $variable_xml->error_code;
            $this->last_message = $variable_xml->message;
            $variable_array = array();
            if ($variable_xml->error_code == 0) {
                foreach ($variable_xml->template_doc->parms->parm_name as $variable) {
                    $variable_array[] = $variable;
                }
                return $variable_array;
            } else {
                return false;
            }
        } else {
            $this->last_error_code = 999;
            $this->last_message = "Unusable response from server.  Check if server path is correct.";
            return false;
        }
        unset($variable_xml);
        unset($variable);
    }

    function getTemplateList() {
        @$list_xml = simplexml_load_string(file_get_contents("{$this->server_url}/meta.php?mode=template_list&token={$this->token}"));
        if ($list_xml) {
            $this->last_error_code = $list_xml->error_code;
            $this->last_message = $list_xml->message;
            $list_array = array();
            if ($list_xml->error_code == 0) {
                foreach ($list_xml->templates->template as $doc) {
                    $list_array[] = array(
                        "id" => $doc->doc_id,
                        "name" => $doc->doc_name,
                        "description" => $doc->doc_desc,
                        "status" => $doc->status,
                        "version" => $doc->version,
                        "file" => $doc->file
                    );
                }
                return $list_array;
            } else {
                return false;
            }
        } else {
            $this->last_error_code = 999;
            $this->last_message = "Unusable response from server.  Check if server path is correct.";
            return false;
        }
        unset($list_xml);
        unset($list_array);
    }

    function createBatch($batch_name, $batch_created_by) {
        $batch_name = htmlentities($batch_name);
        $batch_created_by = htmlentities($batch_created_by);
        $this->disposeBatch();
        $this->batch_xml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>
                    <request_batch>
                    <request_batch_name>{$batch_name}</request_batch_name>
                    <request_batch_by>{$batch_created_by}</request_batch_by>
                    ";
        $this->batch_open = true;
        $this->last_error_code = 0;
        $this->last_message = "Local batch created.";
        return $this->batch_open;
    }

    function addRequestToBatch($request_package_name) {
        $request_package_name = htmlentities($request_package_name);
        if ($this->batch_open == true and $this->request_open == false) {
            $this->batch_xml .= "<request>
            <request_package>{$request_package_name}</request_package>";
            $this->request_open = true;
        } else if ($this->batch_open == true and $this->request_open == true) {
            $this->batch_xml .= "</request>
            <request>
            <request_package>{$request_package_name}</request_package>";
            $this->request_open = true;
        }
        $this->last_error_code = 0;
        $this->last_message = "Request added to batch.";
        return $this->request_open;
    }

    function addDocumentToRequest($document_id, $document_guid) {
        $document_id = htmlentities($document_id);
        $document_guid = htmlentities($document_guid);
        if (empty($document_guid)) {
            $document_guid = htmlentities(uniqid(null, true));
        }
        if ($this->batch_open == true and $this->request_open == true) {
            $this->batch_xml .= "<request_parm>
            <parm_name>REQUEST_DOC_ID</parm_name>
            <parm_value>{$document_id}</parm_value>
            <parm_guid>{$document_guid}</parm_guid>
            </request_parm>";
            $this->last_error_code = 0;
            $this->last_message = "Document added to request.";
            return true;
        } else {
            $this->last_error_code = 999;
            $this->last_message = "No request open to add document to.";
            return false;
        }
    }

    function addParameterToRequest($parameter_name, $parameter_value) {
        $parameter_name = htmlentities($parameter_name);
        $parameter_value = htmlentities($parameter_value);
        if ($this->batch_open == true and $this->request_open == true) {
            $this->batch_xml .= "<request_parm>
            <parm_name>{$parameter_name}</parm_name>
            <parm_value>{$parameter_value}</parm_value>
            </request_parm>";
            $this->last_error_code = 0;
            $this->last_message = "Parameter added to request.";
            return true;
        } else {
            $this->last_error_code = 999;
            $this->last_message = "No request to add parameter to.";
            return false;
        }
    }

    function addParameterRowsetToRequest($parameter_rowset) {
        if ($this->batch_open == true and $this->request_open == true) {
            $row_number = 1;
            $all_parameters = array();
            foreach ($parameter_rowset as $row) {
                foreach ($row as $column => $value) {
                    $column = $column . $row_number;
                    $all_parameters[$column] = $value;
                }
                $row_number++;
            }
            foreach ($all_parameters as $parameter_name => $parameter_value) {
                $parameter_name = htmlentities($parameter_name);
                $parameter_value = htmlentities($parameter_value);
                $this->batch_xml .= "<request_parm>
            <parm_name>{$parameter_name}</parm_name>
            <parm_value>{$parameter_value}</parm_value>
            </request_parm>";
                $this->last_error_code = 0;
                $this->last_message = "Parameter added to request.";
            }
            return true;
        } else {
            $this->last_error_code = 999;
            $this->last_message = "No request to add parameter to.";
            return false;
        }
    }

    function closeBatch() {
        if ($this->batch_open == true and $this->request_open == false) {
            $this->batch_xml .= "</request_batch>";
            $this->batch_open = false;
            $this->last_error_code = 0;
            $this->last_message = "Local batch closed.";
            return true;
        } else if ($this->batch_open == true and $this->request_open == true) {
            $this->batch_xml .= "</request></request_batch>";
            $this->request_open = false;
            $this->batch_open = false;
            $this->last_error_code = 0;
            $this->last_message = "Local batch closed.";
            return true;
        } else {
            $this->last_error_code = 999;
            $this->last_message = "No batch to close.";
            return false;
        }
    }

    function disposeBatch() {
        $this->batch_xml = null;
        $this->request_open = false;
        $this->batch_open = false;
        $this->last_error_code = 0;
        $this->last_message = "Batch disposed of.";
    }

    function getBatchXML() {
        return $this->batch_xml;
    }

    function submitBatch() {
        if ($this->batch_open == true) {
            $this->closeBatch();
        }
        $url = "{$this->server_url}/request.php?mode=submit&token={$this->token}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $post_array = array(
            "base64_request_xml" => base64_encode($this->batch_xml)
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array);
        $response = curl_exec($ch);
        @$response_xml = simplexml_load_string($response);
        if ($response_xml == false) {
            $this->last_error_code = 999;
            return array(
                "error" => true,
                "message" => $this->last_message = "Unusable response from server.  Check if server path is correct.",
                "batch_guid" => null,
                "batch_xml" => $this->batch_xml
            );
        } else {
            if ($response_xml->error_code == 0) {
                $this->last_error_code = $response_xml->error_code;
                return array(
                    "error" => false,
                    "message" => $this->last_message = $response_xml->message,
                    "batch_guid" => $response_xml->batch_guid,
                    "batch_xml" => $this->batch_xml
                );
            } else {
                $this->last_error_code = $response_xml->error_code;
                return array(
                    "error" => true,
                    "message" => $this->last_message = $response_xml->message,
                    "batch_guid" => null,
                    "batch_xml" => $this->batch_xml
                );
            }
        }
        unset($response_xml);
        unset($url);
        unset($response);
        unset($post_array);
    }

    function getSubmittedBatchList($batch_status) {
        $batch_status = urldecode($batch_status);
        @$list_xml = simplexml_load_string(file_get_contents("{$this->server_url}/request.php?mode=batch_list&batch_status={$batch_status}&token={$this->token}"));
        if ($list_xml) {
            $this->last_error_code = $list_xml->error_code;
            $this->last_message = $list_xml->message;
            $list = array();
            if ($list_xml->error_code == 0) {
                foreach ($list_xml->batch_list->batch as $batch) {
                    $list[] = $batch->batch_guid;
                }
                return $list;
                unset($list);
                unset($list_xml);
            } else {
                return false;
            }
        } else {
            $this->last_error_code = 999;
            $this->last_message = "Unusable response from server.  Check if server path is correct.";
            return false;
        }
        unset($list_xml);
        unset($batch);
        unset($list);
    }

    function closeSubmittedBatch($batch_guid) {
        $batch_guid = urlencode($batch_guid);
        $url = "{$this->server_url}/request.php?mode=close_batch&batch_guid={$batch_guid}&token={$this->token}";
        $response = file_get_contents($url);
        @$response_xml = simplexml_load_string($response);
        if ($response_xml == false) {
            $this->last_error_code = 999;
            return array(
                "error" => true,
                "message" => $this->last_message = "Unusable response from server.  Check if server path is correct.",
                "document_id" => null
            );
        } else {
            $this->last_error_code = $response_xml->error_code;
            if ($response_xml->error_code == 0) {
                return array(
                    "error" => false,
                    "message" => $this->last_message = $response_xml->message,
                    "document_id" => $response_xml->doc_id
                );
            } else {
                return array(
                    "error" => true,
                    "message" => $this->last_message = $response_xml->message,
                    "document_id" => null
                );
            }
        }
        unset($response_xml);
        unset($url);
        unset($response);
    }

    function archiveSubmittedBatch($batch_guid) {
        $batch_guid = urlencode($batch_guid);
        $url = "{$this->server_url}/request.php?mode=archive_batch&batch_guid={$batch_guid}&token={$this->token}";
        $response = file_get_contents($url);
        @$response_xml = simplexml_load_string($response);
        if ($response_xml == false) {
            $this->last_error_code = 999;
            return array(
                "error" => true,
                "message" => $this->last_message = "Unusable response from server.  Check if server path is correct.",
                "document_id" => null
            );
        } else {
            $this->last_error_code = $response_xml->error_code;
            if ($response_xml->error_code == 0) {
                return array(
                    "error" => false,
                    "message" => $this->last_message = $response_xml->message,
                    "document_id" => $response_xml->doc_id
                );
            } else {
                return array(
                    "error" => true,
                    "message" => $this->last_message = $response_xml->message,
                    "document_id" => null
                );
            }
        }
        unset($response_xml);
        unset($url);
        unset($response);
    }

    function checkSubmittedBatch($batch_guid) {
        @$check_xml = simplexml_load_string(file_get_contents("{$this->server_url}/request.php?mode=check_batch&batch_guid={$batch_guid}&token={$this->token}"));
        if ($check_xml) {
            $this->last_error_code = $check_xml->error_code;
            $this->last_message = $check_xml->message;
            $check_array = array();
            if ($check_xml->error_code == 0) {
                foreach ($check_xml->batch as $b) {
                    foreach ($b->request as $r) {
                        foreach ($r->document as $d) {
                            $check_array[] = array(
                                "batch_guid" => $b->batch_guid,
                                "batch_status" => $b->batch_status,
                                "request_id" => $r->request_id,
                                "request_status" => $r->request_status,
                                "request_started" => $r->request_started,
                                "request_completed" => $r->request_completed,
                                "document_id" => $d->document_id,
                                "document_serial" => $d->document_serial,
                                "document_status" => $d->document_status,
                                "document_guid" => $d->document_guid,
                                "document_path" => $d->document_path,
                                "document_started" => $d->document_started,
                                "document_completed" => $d->document_completed,
                                "document_message" => $d->document_message
                            );
                        }
                    }
                }
                return $check_array;
            } else {
                return false;
            }
        } else {
            $this->last_error_code = 999;
            $this->last_message = "Unusable response from server.  Check if server path is correct.";
            return false;
        }
        unset($check_xml);
        unset($check_array);
    }

    function getDocumentString($document_guid) {
        $return = file_get_contents("{$this->server_url}/retrievedoc.php?guid={$document_guid}&token={$this->token}");
        if (!empty($return)) {
            return $return;
        } else {
            return false;
        }
    }

    function writeDocumentToFile($document_guid, $file_location) {
        $return = file_get_contents("{$this->server_url}/retrievedoc.php?guid={$document_guid}&token={$this->token}");
        if (!empty($return)) {
            if (file_put_contents($file_location, $return)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}

?>