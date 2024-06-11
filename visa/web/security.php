<?php

define ('HMAC_SHA256', 'sha256');
define ('SECRET_KEY', '6f335d88adc14c9c9b06192dc07240f5ab7b1bb83b654d36bf02533cedc881c77c3e0de401254bd7ac4b9ffa374c433ca4d2acfb67ab40aeb1973b93dd93f4406da080b3ceea430ca003eb1b17e348129a4c2dc6609144f9a2b2f1d7dfd373315c0392b80df0430fb613ab5aaad256f65f2f1fa602c84939a4a93ee336d9c54d');

function sign ($params) {
  return signData(buildDataToSign($params), SECRET_KEY);
}

function signData($data, $secretKey) {
    return base64_encode(hash_hmac('sha256', $data, $secretKey, true));
}

function buildDataToSign($params) {
        $signedFieldNames = explode(",",$params["signed_field_names"]);
        foreach ($signedFieldNames as $field) {
           $dataToSign[] = $field . "=" . $params[$field];
        }
        return commaSeparate($dataToSign);
}

function commaSeparate ($dataToSign) {
    return implode(",",$dataToSign);
}

?>
