<?php

class ContactModel extends Model
{
    public function Index()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($post['submit'])
        {
            $to      = 'lacombe.dominique@outlook.fr';
            $subject = $post['subject'];
            $message = $post['message'];
            $headers = 'From: '. $post['email'] . "\r\n" .
                'Reply-To: ' . $post['email'] . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);
        }
        return;
    }
}
?>