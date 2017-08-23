<?php
function getBrowser() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version = "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif(preg_match('/Firefox/i',$u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif(preg_match('/Chrome/i',$u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }elseif(preg_match('/Safari/i',$u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }elseif(preg_match('/Opera/i',$u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    }elseif(preg_match('/Netscape/i',$u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';

    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);

    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet

        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }else {
            $version= $matches['version'][1];
        }
    }else {
        $version= $matches['version'][0];
    }

    // check if we have a number
    if ($version == null || $version == "") {$version = "?";}
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'   => $pattern
    );
}

// now try it
$ua = getBrowser();
$yourbrowser = "<p>Your browser: " . $ua['name'] . " " . $ua['version'] .
    " on " .$ua['platform'] . " reports: <br >" . $ua['userAgent'] . "</p>";

print_r($yourbrowser);
?>
<?php
srand( microtime() * 1000000 );
$num = rand( 1, 3 );

switch( $num ) {
    case 1: $image_file = "images/1.png";
        break;

    case 2: $image_file = "images/2.jpg";
        break;

    case 3: $image_file = "images/3.jpg";
        break;
}
echo "Random Image : <img style='max-width: 400px;' src=$image_file />";
?>
<?php
if(isset($_POST["name"]) && isset($_POST["age"])) {
    if( $_POST["name"] || $_POST["age"] ) {
        if (preg_match("/[^A-Za-z'-]/",$_POST['name'] )) {
            die ("invalid name and name should be alpha");
        }

        echo "<br />Welcome ". $_POST['name']. "<br />";
        echo "You are ". $_POST['age']. " years old.";

        exit();
    }
}

?>

<?php
if( $_POST["location"] ) {
    $location = $_POST["location"];
    header( "Location:$location" );

    exit();
}
?>
<html>
<body>

<form action = "<?php $_PHP_SELF ?>" method = "POST">
    Name: <input type = "text" name = "name" />
    Age: <input type = "text" name = "age" />
    <input type = "submit" />
</form>
<p>Choose a site to visit :</p>

<form action = "<?php $_SERVER['PHP_SELF'] ?>" method ="POST">
    <select name = "location">.

        <option value = "http://www.tutorialspoint.com">
            Tutorialspoint.com
        </option>

        <option value = "http://www.google.com">
            Google Search Page
        </option>

    </select>
    <input type = "submit" />
</form>
</body>
</html>