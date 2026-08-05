<?php 
    $APP_URL = env('APP_URL');
    $Sidebar = "Pagina Principal";
    function toast($timer,$title,$icon){
        return "toastMixin.fire({
            timer: $timer,
            title: '$title',
            icon: '$icon'
        });";
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Template</title>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="<?= url('images/icon.png') ?>" type="image/x-icon"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    var toastMixin = Swal.mixin({
        toast: true,
        icon: 'success',
        title: 'General Title',
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    </script>
    <style>
        .blink{
            animation-duration: 1200ms;
            animation-name: blink;
            animation-iteration-count: infinite;
            animation-direction: alternate;
            -webkit-animation:blink 1200ms infinite; /* Safari and Chrome */
        }
        @keyframes blink {
            from {
                color:#8c0000;
            }
            to {
                color:#ff0101;
            }
        }
        @-webkit-keyframes blink {
            from {
                color:#8c0000;
            }
            to {
                color:#ff0101;
            }
        }
        .lds-dual-ring {
            display: inline-block;
            width: 80px;
            height: 80px;
        }
        .lds-dual-ring:after {
            content: " ";
            display: block;
            width: 64px;
            height: 64px;
            margin: 8px;
            border-radius: 50%;
            border: 6px solid #0062b0;
            border-color: #0062b0 transparent #0062b0 transparent;
            animation: lds-dual-ring 1.2s linear infinite;
        }
        @keyframes lds-dual-ring {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
        .mouse-click:hover > td{
            background: #f0f0f0;
            cursor: pointer;
        }
        .pointer:hover{
            cursor: pointer;
        }
        p{
            margin-bottom: 0;
        }
        .required::after{
            content: "*";
            color: red;
        }
        @media print{
            .hideprint{
                display: none;
            }
            .showprint{
                width: 100%;
            }
            .y-scroll{
                max-height: 100vh !important;
                height: 100% !important;
                overflow-y: hidden !important;
            }
            .card{
                border: none;
            }
            .shadow{
                box-shadow: 0 .5rem 1rem rgba(0,0,0,0)!important
            }
        }
    </style>
</head>
<body>  
    