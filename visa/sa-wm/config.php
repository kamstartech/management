<?php

define('MERCHANT_ID', 'zanaco_eden_uni');
define('PROFILE_ID',  '947D92B0-80C7-4E39-B084-0292F084039C');
define('ACCESS_KEY',  'c85943a1f3b53f9fb76751dbf88e436c');
define('SECRET_KEY',  '6f335d88adc14c9c9b06192dc07240f5ab7b1bb83b654d36bf02533cedc881c77c3e0de401254bd7ac4b9ffa374c433ca4d2acfb67ab40aeb1973b93dd93f4406da080b3ceea430ca003eb1b17e348129a4c2dc6609144f9a2b2f1d7dfd373315c0392b80df0430fb613ab5aaad256f65f2f1fa602c84939a4a93ee336d9c54d');

// DF TEST: 1snn5n9w, LIVE: k8vif92e 
define('DF_ORG_ID', '1snn5n9w');

// PAYMENT URL
define('CYBS_BASE_URL', 'https://testsecureacceptance.cybersource.com');
//define('CYBS_BASE_URL', 'https://ebctest.cybersource.com');

define('PAYMENT_URL', CYBS_BASE_URL . '/pay');
// define('PAYMENT_URL', '/sa-sop/debug.php');

define('TOKEN_CREATE_URL', CYBS_BASE_URL . '/token/create');
define('TOKEN_UPDATE_URL', CYBS_BASE_URL . '/token/update');

// EOF