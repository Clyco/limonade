<?php
if(!defined('LIMONADE')){$h="HTTP/1.0 401 Unauthorized";header($h);die($h);}// Security check

test_case("HTTP");
   test_case_describe("Testing limonade HTTP utils functions.");
   
   function test_http_ua_accepts()
   {
     $env = env();

     $env['SERVER']['HTTP_ACCEPT'] = null;
     assert_true(http_ua_accepts('text/plain'));

     $env['SERVER']['HTTP_ACCEPT'] = 'text/html';
     assert_true(http_ua_accepts('html'));

     $env['SERVER']['HTTP_ACCEPT'] = 'text/*; application/json';     
     assert_true(http_ua_accepts('html'));
     assert_true(http_ua_accepts('text/html'));
     assert_true(http_ua_accepts('text/plain'));
     assert_true(http_ua_accepts('application/json'));
     
     assert_false(http_ua_accepts('image/png'));
     assert_false(http_ua_accepts('png'));
     
     assert_true(defined('TESTS_DOC_ROOT'), "Undefined 'TESTS_DOC_ROOT' constant");
     
     $response =  test_request(TESTS_DOC_ROOT.'05-content_negociation.php', 'GET', false, array(), array("Accept: image/png"));
     assert_equal("Oops", $response);
     
     $response =  test_request(TESTS_DOC_ROOT.'05-content_negociation.php', 'GET', false, array(), array("Accept: text/html"));
     assert_equal("<h1>HTML</h1>", $response);
     
     $response =  test_request(TESTS_DOC_ROOT.'05-content_negociation.php', 'GET', false, array(), array("Accept: application/json"));
     assert_equal("json", $response);
   }
   
end_test_case();