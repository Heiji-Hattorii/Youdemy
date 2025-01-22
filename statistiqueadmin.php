<?php
require 'classes/class.admin.php';
session_start();
$admin= new Admin();

$categories = $admin->repartition();

$labels = [];
$data = [];

foreach ($categories as $category) {
    $labels[] = $category['nom_categorie'];  
    $data[] = (int)$category['nb_cours'];    
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</head>

<body>
    <?php include 'header.php'?>
    <div class="relative z-10 flex flex-row gap-4 h-max text-center text-white bg-black bg-opacity-30">


        <div class="main absolute  w-[100%] min-h-[100vh]">
            <div class="cards w-[100%] py-[35px] px-[40px] grid grid-cols-3 gap-[40px]">
                <div class="card p-[20px] flex align-center space-around bg-[#fff] rounded-lg shadow-md relative">
                    <div class="card_content ">
                        <div class="number text-2xl font-bold text-red-700 pb-[10px]">
                            <?=htmlspecialchars($admin->countcours()) ?> </div>
                        <div class="card_name text-[#d5d5d5] font-[700] text-md">Total cours</div>
                    </div>

                </div>
                <div class="card card p-[20px] flex align-center space-between bg-[#fff] rounded-lg shadow-md relative">
                    <div class="card_content">
                        <div class="number text-2xl font-bold text-red-700 pb-[10px]">
                            <?=htmlspecialchars($admin->courplusetudiant() ? $admin->courplusetudiant()['titre'] : 'Aucun cours trouve') ?></div>
                        <div class="card_name  text-[#d5d5d5] font-[700]">Le livre avec les plus inscris </div>
                    </div>

                </div>
                

            </div>
            <div class="w-[40%] h-[70%]">
                <canvas id="myChart" width="400" height="200"></canvas>

                </div>
        </div>
    </div>
    
    <script>
        var labels = <?php echo json_encode($labels); ?>;
        var data = <?php echo json_encode($data); ?>;

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',  
            data: {
                labels: labels,  
                datasets: [{
                    label: 'Repartition des cours par categorie',
                    data: data,  
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',  
                    borderColor: 'rgba(54, 162, 235, 1)', 
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true  
                    }
                }
            }
        });
    </script>
</body>

</html>