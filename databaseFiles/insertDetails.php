<?php
// Including database connections
require_once 'database_connections.php';
require "twitteroauth/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;



//$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token, $access_token_secret);
//$content = $connection->get("account/verify_credentials");

$twitteruser = "BlankOnLinux";
$notweets = 30;
$consumerkey = getenv('TW_CONSUMER_KEY');
$consumersecret = getenv('TW_SECRET_KEY');
$accesstoken = getenv('TW_ACCESS_TOKEN');
$accesstokensecret = getenv('TW_ACCESS_TOKEN_SECRET');

function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
  return $connection;
}


// Fetching and decoding the inserted data
$data = json_decode(file_get_contents("php://input"));
// Escaping special characters from submitting data & storing in new variables.
$name = mysqli_real_escape_string($con, $data->name);
$country = mysqli_real_escape_string($con, $data->country);
//$gender = mysqli_real_escape_string($con, $data->gender);
$comment = mysqli_real_escape_string($con, $data->comment);
$email = mysqli_real_escape_string($con, $data->email);
$twitterid = mysqli_real_escape_string($con, $data->twitterid);
$twitterid = "@".$twitterid;
$binary_data = base64_decode( mysqli_real_escape_string($con, $data->photo) );
$photo_name = "img/".$twitterid.".jpg";
$photoAddr = "/var/www/html/tmp/".$photo_name;
    // save to server (beware of permissions)

$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);

$str_name = $comment . ". Yuk, berkunjung ke stan #BlankOn di #BekrafHabibieFestival -- " . $name . " (" . $twitterid . ") dari " . $country;
//$tweets = $connection->post("statuses/update", ["status" => $str_name]);

/*
$media1 = $connection->upload('media/upload', ['media' => $photo_name]);
$media2 = $connection->upload('media/upload', ['media' => $photo_name]);
$parameters = [
    'status' => $str_name,
    'media_ids' => implode(',', [$media1->media_id_string,$media2->media_id_string])
];
$result = $connection->post('statuses/update', $parameters);
*/

//$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token, $access_token_secret);




$result = file_put_contents( $photo_name, $binary_data );
//if (!$result) die("Could not save image!  Check file permissions.");
if (!$result) $photoAddr='';


$media1 = $connection->upload('media/upload', ['media' => $photo_name]);
$parameters = [
    'status' => $str_name,
    'media_ids' => implode(',', [$media1->media_id_string]),
];
$result = $connection->post('statuses/update', $parameters);

echo "cek";
echo json_encode($result);

// mysqli insert query
$query = "INSERT into visitor_details (visitor_name,visitor_country,visitor_email,visitor_twitterid,visitor_comment,visitor_photoaddr) VALUES ('$name','$country','$email','$twitterid','$comment','$photoAddr')";
// Inserting data into database
mysqli_query($con, $query);
echo true;
?>
