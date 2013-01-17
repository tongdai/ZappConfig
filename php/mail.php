<?php
// mail.php
// Author: Bobby Hazel
// Date: 1/15/13
// Purpose: Delivers all Zapp Config data through an email with an attached zip 
// file containing all submittedt images
//


//Change and create company directory
chdir('clients'); 
mkdir($_POST['company']);

//Place Images In Folder
if(count($_FILES['file']['name']))
  {
        $target = $_POST['company'] . "/";
        $count = 0;
        foreach ($_FILES['file']['name'] as $filename)
        {
            $dir = $target;
            $tmp = $_FILES['file']['tmp_name'][$count];
            $count = $count + 1;
            $dir = $dir.basename($filename);
            move_uploaded_file($tmp,$dir);
            $dir = '';
            $tmp = '';
        };
  };

//Create Zipped Folder  
ZappZip::zipDir($_POST['company'].'/' , $_POST['company'] ."/". $_POST['company'].".zip");

/*
*
* EMAIL CONTENT
*
*/
$to = "kba@zmags.com";
$subject = $_POST['company'] . " Zapp Configuration";

$random_hash = md5(date('r', time())); 
//define the headers we want passed. Note that they are separated with \r\n 
$headers = "From:". $_POST['email_address'] . "\r\nReply-To:" . $_POST['email_address']; 
//add boundary string and mime type specification 
$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 
//read the atachment file contents into a string,
//encode it with MIME base64,
//and split it into smaller chunks

$attachment = chunk_split(base64_encode(file_get_contents($_POST['company'] ."/". $_POST['company'] . ".zip"))); 
//define the body of the message. 
ob_start(); //Turn on output buffering 
?> 
--PHP-mixed-<?php echo $random_hash; ?>  
Content-Type: multipart/alternative; boundary="PHP-alt-<?php echo $random_hash; ?>" 


--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/html; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

<html>
<head>
    <style type="text/css">

    </style>
</head>
<body>

<?php 
    $carousel = isset($_POST['featured_carousel'])? '' : 'display : none'; 
    $navigation = isset($_POST['navigation_module'])? '' : 'display : none'; 
    $featured_carousel_header = isset($_POST['featured_publications_carousel_header'])? '' : 'display : none';
?>

    <h1><?php echo $_POST['company']?> Zapp Configuration</h1>
        <h2>General Zapp Configuration</h2>
            <ul>
                <li><b>Splash Image: </b><?php echo $_POST['id_splash_loading_image'] ?></li>
                <li><b>Top Navigation Color: </b><?php echo $_POST['top_navigation_color']?></li>
                <li><b>Top Right Navigation Image: </b><?php echo $_POST['id_top_right_navigation_image']?></li>
                <li><b>Top Left Navigation Image: </b><?php echo $_POST['id_top_left_navigation_image']?></li>
                <li><b>Bottom Navigation Color: </b><?php echo $_POST['bottom_navigation_color']?></li>
                <li><b>Bottom Right Navigation Image: </b><?php echo $_POST['id_bottom_right_navigation_image']?></li>
                <li><b>Bottom Left Navigation Image: </b><?php echo $_POST['id_bottom_left_navigation_image']?></li>
            </ul>
        <?php echo '<div style="'.$navigation.'">'?>
        <h2>Navigation Module</h2>
            <ul>
                <li><b>Navigation Module Color: </b><?php echo $_POST['navigation_module_color']?></li>
                <li><b>Navigation Module Image: </b><?php echo $_POST['id_navigation_module_image']?></li>
                <li><b>Navigation Module Title: </b><?php echo $_POST['navigation_module_title']?></li>
            </ul>
        </div>

        <?php echo '<div style="'.$carousel.'">'?>
        <h2>Featured Publications Module</h2>
            <ul>
                <li><b>Display Top Navigation Bar: </b><?php echo $_POST['featured_publications_navigation_bar']?></li>
                <li><b>Background Color: </b><?php echo $_POST['featured_publications_background_color']?></li>
                <li><b>Background Image: </b><?php echo $_POST['id_featured_publications_background_image']?></li>
                <li><b>Display Carousel Header: </b><?php echo $_POST['featured_publications_carousel_header']?></li>
                    <?php echo '<ul style="'.$carousel.'">'?>
                        <li><b>Carousel Header Font: </b><?php echo $_POST['featured_publications_carousel_header_font']?></li>
                        <li><b>Carousel Header Font Color: </b><?php echo $_POST['featured_publications_carousel_header_color']?></li>
                    </ul>
                <li><b>Publication Title Color: </b><?php echo $_POST['featured_publications_publication_title_color']?></li>
                <li><b>Side Navigation Arrow Color: </b><?php echo $_POST['featured_publications_publications_arrow_color']?></li>
            </ul>
        </div>
        <h2>Library Module</h2>
            <ul>
                <li><b>Display Top Navigation Bar: </b><?php echo $_POST['library_navigation_bar']?></li>
                <li><b>Background Color: </b><?php echo $_POST['library_background_color']?></li>
                <li><b>Background Image: </b><?php echo $_POST['id_library_background_image']?></li>
                <li><b>Gradient: </b><?php echo $_POST['library_gradient']?></li>
                <li><b>Shelf Edge Color: </b><?php echo $_POST['library_shelf_edge_color']?></li>
                <li><b>Shelf Surface Color: </b><?php echo $_POST['library_shelf_surface_color']?></li>
                <li><b>Shelf Title Font: </b><?php echo $_POST['library_shelf_title_font']?></li>
                <li><b>Shelf Title Font Color: </b><?php echo $_POST['library_shelf_title_font_color']?></li>
                <li><b>Publication Title Font: </b><?php echo $_POST['library_publication_title_font']?></li>
                <li><b>Publication Title Font Color: </b><?php echo $_POST['library_publication_title_font_color']?></li>
                <li><b>Thumbnails: </b><?php echo $_POST['library_thumbnail']?></li>
                <li><b>Titles: </b><?php echo $_POST['library_title']?></li>
            </ul>
        <h2>Publication Viewer</h2>
            <ul>
                <li><b>Display Viewer Top Navigation: </b><?php echo $_POST['viewer_navigation'] ?></li>
                <li><b>Viewer Loading Image: </b><?php echo $_POST['viewer_loading_image']?></li>
                <li><b>Background Color: </b><?php echo $_POST['viewer_background_color']?></li>
                <li><b>Background Image: </b><?php echo $_POST['id_viewer_background_image']?></li>
                <li><b>Bottom Slide Navigation: </b><?php echo $_POST['viewer_color_scheme']?></li>
            </ul>
        <h2>Twitter and YouTube</h2>
            <ul>
                <li><b>Display Navigation Bar: </b><?php echo $_POST['twitter_youtube_navigation_bar']?></li>
                <li><b>Background Color: </b><?php echo $_POST['twitter_youtube_background_color']?></li>
                <li><b>Background Image: </b><?php echo $_POST['id_twitter_youtube_background_image']?></li>
                <li><b>Twitter Handle: </b><?php echo $_POST['twitter_account']?></li>
                <li><b>Youtube URL: </b><?php echo $_POST['youtube_url']?></li>
            </ul>

</body>
</html>

--PHP-alt-<?php echo $random_hash; ?>-- 

--PHP-mixed-<?php echo $random_hash; ?>  
Content-Type: application/zip; name=<?php echo $_POST['company'].".zip"?>;  
Content-Transfer-Encoding: base64  
Content-Disposition: attachment  

<?php echo $attachment; ?> 

--PHP-mixed-<?php echo $random_hash; ?>-- 

<?php 
//copy current buffer contents into $message variable and delete current output buffer 
$message = ob_get_clean(); 
//send the email 
$mail_sent = @mail( $to, $subject, $message, $headers ); 
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
echo $mail_sent ? "Mail sent" : "Mail failed"; 

//Class to zip a folder and its contents
class ZappZip {
  /**
   * Add files and sub-directories in a folder to zip file.
   * string $folder
   * ZipArchive $zipFile
   * int $exclusiveLength Number of text to be exclusived from the file path.
   */
  private static function folderToZip($folder, &$zipFile, $exclusiveLength) {
    $handle = opendir($folder);
    while ($f = readdir($handle)) {
      if ($f != '.' && $f != '..') {
        $filePath = "$folder/$f";
        // Remove prefix from file path before add to zip.
        $localPath = substr($filePath, $exclusiveLength);
        if (is_file($filePath)) {
          $zipFile->addFile($filePath, $localPath);
        } elseif (is_dir($filePath)) {
          // Add sub-directory.
          //$zipFile->addEmptyDir($localPath);
          self::folderToZip($filePath, $zipFile, $exclusiveLength);
        }
      }
    }
    closedir($handle);
  }

  /**
   * Zip a folder (include itself).
   * Usage:
   *   HZip::zipDir('/path/to/sourceDir', '/path/to/out.zip');
   *
   * string $sourcePath Path of directory to be zip.
   * string $outZipPath Path of output zip file.
   */
  public static function zipDir($sourcePath, $outZipPath)
  {
    $pathInfo = pathInfo($sourcePath);
    $parentPath = $pathInfo['dirname'];
    $dirName = $pathInfo['basename'];

    $z = new ZipArchive();
    $z->open($outZipPath, ZIPARCHIVE::CREATE);
    //$z->addEmptyDir($dirName);
    self::folderToZip($sourcePath, $z, strlen($dirName));
    $z->close();
  }
}
?>