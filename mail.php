<?php

if ( isset($_POST["name"])) {

    $admin_email = '';

    $name  = $_POST["name"];
    $email = $_POST["email"];
    $tel   = $_POST["tel"];
    $text  = $_POST["text"];
    $the_file  = $_POST["file"];
    $the_file_type = $_POST["file_type"];
    $the_file_name = $_POST["file_name"];


    $message = "Наименование организации: $name\n" . "Email: $email\n" . "Телефон: $tel\n". "Текст: $text\n";
    
    class mail {
     
        public static function prepareAttachmentImg($img, $img_name, $img_type) {
            $rn = "\r\n";

            $attachment = chunk_split($img);

            $msg = 'Content-Type: \'' . $img_type . '\'; name="' . basename($img_name) . '"' . $rn;
            $msg .= "Content-Transfer-Encoding: base64" . $rn;
            $msg .= 'Content-ID: <' . basename($img_name) . '>' . $rn;
            $msg .= $rn . $attachment . $rn . $rn;
            return $msg;
        }
     
        public static function sendMail($to, $subject, $content, $cc = '', $bcc = '', $_headers = false, $file = '', $file_name = '', $file_type = '') {
            $rn = "\r\n";
            $boundary = md5(rand());
            $boundary_content = md5(rand());
     
            // Headers
            $host = $_SERVER['HTTP_HOST'];
            $headers = "From: Изготовление печати <no-reply@".$host.">" . $rn;
            $headers .= 'Mime-Version: 1.0' . $rn;
            $headers .= 'Content-Type: multipart/related;boundary=' . $boundary . $rn;
     
            //adresses cc and ci
            if ($cc != '') {
                $headers .= 'Cc: ' . $cc . $rn;
            }
            if ($bcc != '') {
                $headers .= 'Bcc: ' . $cc . $rn;
            }
            $headers .= $rn;
     
            // Message Body
            $msg = $rn . '--' . $boundary . $rn;
            $msg.= "Content-Type: multipart/alternative;" . $rn;
            $msg.= " boundary=\"$boundary_content\"" . $rn;
     
            //Body Mode text
            $msg.= $rn . "--" . $boundary_content . $rn;
            $msg .= 'Content-Type: text/plain; charset=utf-8' . $rn;
            $msg .= strip_tags($content) . $rn;
     
            //Body Mode Html        
            $msg.= $rn . "--" . $boundary_content . $rn;
            $msg .= 'Content-Type: text/html; charset=utf-8' . $rn;
            $msg .= 'Content-Transfer-Encoding: quoted-printable' . $rn;

            $msg .= $rn . '<div>' . nl2br(str_replace("=", "=3D", $content)) . '</div>' . $rn;

            $msg .= $rn . '--' . $boundary_content . '--' . $rn;
     
            // if attachement
            if ($file != '') {
                $conAttached = self::prepareAttachmentImg($file,$file_name,$file_type);
                if ($conAttached !== false) {
                    $msg .= $rn . '--' . $boundary . $rn;
                    $msg .= $conAttached;
                }
            }
            
            // Fin
            $msg .= $rn . '--' . $boundary . '--' . $rn;
     
            // Function mail()
            if(mail($to, $subject, $msg, $headers)){
                return 1;
            } else {
                return 0;
            }
        }
    }

    $send = new mail(); 

    echo $send->sendMail($admin_email, "Форма с сайта ".  date("H:i:s"), $message, $email,'' , true, $the_file, $the_file_name, $the_file_type);
}  
?>
