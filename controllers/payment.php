<?php
    include("includes/connectdb.php");
?>
<?php 
    if ( isset( $_POST['billingId']) && isset( $_POST['ref']) ) {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $amount = $_POST['amount'];
        $package = $_POST['package'];
        $amount = $_POST['amount'];
        $ref = $_POST['ref'];
        
        

        $result = array();
        //The parameter after verify/ is the transaction reference to be verified
        $url = 'https://api.paystack.co/transaction/verify/'.$_POST['ref'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer sk_test_1ad9864fbb7876ffae1d2260b34ca75aceec24a6']
        );
        $request = curl_exec($ch);
        curl_close($ch);

        if ($request) {
            $result = json_decode($request, true);
        }
        $array = array('success' => 0);
        $date = date("d-m-Y h:i:sa");
        if (array_key_exists('data', $result) && array_key_exists('status', $result['data']) && ($result['data']['status'] === 'success')) {
            $payAmount = $result['data']['amount'];

            $values = "{$name}', '{$email}', '{$phone}', '{$amount}', '{$package}', '{$ref}', '{$date}";
			$savePayment = mysqli_query($connect, "INSERT INTO payment_tbl(fullname, email, phone, package, amount, ref, date_created) VALUES('{$values}')");
            if(!$savePayment){
                echo "Could not save data: " . mysqli_error($connect);
            }else{
                $array = array('success' => 1);
            }
            echo json_encode($array);
        }else {
            // $array = array('success' => 0);
            echo json_encode($array);
        }
    }else {
        $array = array('success'=> 0);
        echo json_encode($array);
    }