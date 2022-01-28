<?php

session_start();

// function login_check()
// {
//     // $result = false;

//         // if (isset($_SESSION['phoneNumber']) && isset($_SESSION['password']))
//         // {
//         //     $someone = 
//             // $user_data = [
//             //     'email' => $_SESSION['user_email'],
//             //     'password' => $_SESSION['user_password'],
//             // ];

//             // $result_object = $this->login($user_data);

//             // if ($result_object->$result['http_code'] == 200)
//             // {
//             //     $result = true;
//             // }
//         // }

//         return $result;
// }

function update_user_information($data)
{
    empty($request->name) ? : $data['name'] = $request->name;
    empty($request->lastname) ? : $data['lastname'] = $request->lastname;
    empty($request->phoneNumber) ? : $data['phoneNumber'] = $request->phoneNumber;
    empty($request->password) ? : $data['password'] = Hash::make($request->password);

    return $data;
}

?>