<?php
require 'classes/class.enseignants.php';
session_start();
$teach= new Enseignant();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
    <?php include 'header.php'?>
    <div class="relative z-10 flex flex-row gap-4 h-max text-center text-white bg-black bg-opacity-30">


        <div class="main absolute t-[60px] w-[calc(100%-250px)] ml-[250px] min-h-[100vh]">
            <div class="cards w-[100%] py-[35px] px-[40px] grid grid-cols-3 gap-[40px]">
                <div class="card p-[20px] flex align-center space-around bg-[#fff] rounded-lg shadow-md relative">
                    <div class="card_content ">
                        <div class="number text-2xl font-bold text-red-700 pb-[10px]">
                            <?=htmlspecialchars($teach->countmescours($_SESSION['ID_user'])) ?> </div>
                        <div class="card_name text-[#d5d5d5] font-[700] text-md">Total cours</div>
                    </div>

                </div>
                <div class="card card p-[20px] flex align-center space-between bg-[#fff] rounded-lg shadow-md relative">
                    <div class="card_content">
                        <div class="number text-2xl font-bold text-red-700 pb-[10px]">
                            <?=htmlspecialchars($teach->countmesinscris($_SESSION['ID_user'])) ?></div>
                        <div class="card_name  text-[#d5d5d5] font-[700]">Les nombres des inscris </div>
                    </div>

                </div>

            </div>
        </div>