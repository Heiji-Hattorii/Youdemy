<?php
if(isset($_POST['submit'])){

    $file=$_FILES['file']; /* tout les info dyal file quia name file*/

    /*
    array(
    1---ki3ti lna le nom [name] 
    2---  [full_path] (le nzme === full path !!!! but quel est la difference)
    3--- [type] il m a donne application/pdf
    4--- [tmp_name] le nom temporaire c:\wamp64\tmp\php9283.tmp 3talo path tempraire
    5--- error
    6--- [size] 207863 taille dyal file fhad le cas dyal file li uploadit )
    fin d array 
    apres le name de pdf en concatenation avec l array 
    
    et pour image 

    au sii 1[name] 2[full_path] 3[type]==> image/jpeg dans ma cas 
    4[tmp_name]==>c:\wamp64\tmp\php2d02.tmp
    5==>[error] 6==>  [size]) fin d array et apres le nom de l image aussi 
    
    */
    print_r($file);
    $fileName = $_FILES['file']['name']; /* il nous donne le nom de fichier    ici remplacer ['name']*/
    echo $fileName;
    $fileExtension=explode('.',$_FILES ['file']['name']);  /* arraaaaaay*/
    print_r ($fileExtension);
    /* il m a donner ca ===> 
    Array([0]=>le nom de l image [1]=> jpg) donc il m a retourner dans la 1 ere colonne le nom
    de l image puis il m as retourner le type ou bien extension de cette imlage */
    $fileactualext=strtolower(end($fileExtension)); 

    echo '(fileactualextension ===>'.$fileactualext.')'; 
    /* il ma donner seulement jpg pas d array 
    donc je peux dire que la fonction end($variable)  ((est ce variable est array))
     nous retourne la dernier
     colonne d une table string 
    */

    /* et     strtolower    c est juste pour les mettre en lower case*/

    $allowed=array('mp4','webm','wmv') ;

    /* ici on precise les format accepter et on les mettre dans un array */

    print_r(in_array($fileactualext,$allowed));/*
    
    la fonction in_array
    
    
    elle a retourner 1  car l extension exite
    dans le tableau 
    el l na ffiche rieeeeeeeen si il n existe pas (il n affiche ni 0 ni NUll)
    comme si on a rien fait  
    
    meme si on dupplique la valeur de jpg par exemple dans l array et on sait que 
    l image a un type jpg il retourne toujours 1 
    (donc s il existe il affiche 1 sinon il fait rien in n affiche rien )
    */


    if(in_array($fileactualext,$allowed)){ 
        /* la fonction in_array($achercher,$dansarray) 
        sert a chercher une valeur dans une array en parcourir 
        tout le table et chercher la valeur s ils sont egaux ou non 


        1 argument c est le mot a chercher ou bien le variable qu on cherche 
        2argument c est array dans lequel on cherche
        
        */



        if($_FILES['file']['error']===0){
            if($_FILES['file']['size']<1000000){/*one million mega byte*/ 
                
                $fileNameNew=uniqid('',true).".".$fileactualext;
                    /*pour creer un nom de fichier unique on utilise uniqid() la fonction 
                pour qu il genere un nom unique puis on met un point et apres on met
                 l extension de ce fichier  touuuut ca en concatenation !!!!
                 
                  


                 pour unicid le 1 er argument est vide car ca signifie le prefixe de la methode 
                 
                 genrer un identifiant base sur le temps 
                 
                     */
                echo "__________" .$fileNameNew;

                $finalDestination='uploads/'.$fileNameNew;
                echo "____________" .$finalDestination;

                /*ici on a creer le chemain de destination on a deja
                 creer le fichier uploads et on a fait une concatenantion avec le nouveux 
                 file name pour avoir un chemain de destination dans lequel on va mover le 
                 le fichier */

                move_uploaded_file($_FILES['file']['tmp_name'] ,$finalDestination);
                
                /* comme ca on fait deplacer le fichier a partir de folder tmp qui est dans le wamp
                temporairement vers notre final destination 
                
                on utilise tmp_name car dans cette derniere on stocke les fichier dans notre 
                serveur temporairement et si on veut faire moe par exemple on va l effectuer car
                le fichier est deja stocke dans le serveur comme ca on fait
                conversion serveur serveur  */


                //  echo "______" .move_uploaded_file($_FILES['file']['tmp_name'] ,$finalDestination);

                /* il retourne 1 si la le deplacementt a  ete bien effectuer */


                // header("Location:upload.php?uploadsuccess");
                echo '<div class="w-[100px] h-[200px] rounded-lg"><a href=" '.$finalDestination.' " >litre fichier</a> <br/> </div>';
                echo '<a href=" '.$finalDestination.' " download>telecharger fichier</a>';
                echo '<embed src="'.$finalDestination.'"       type="'.$_FILES['file']['type'].'" w-[80%] h-[60%]>';
                    /* embed c est une balise en html pour afficher les fichier "*/


            
             }
             else{
                        echo "your file is too big!!!";
                    }
                }
        else{
            echo "il yèa un probleme !!!!";    }

            }
        
     else{
        echo 'le file est invalide';
        }



/* $fileNameNew=uniqid('',true).".".$fileactualext;*/
}








?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=form, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="file">
        <button type="submit" name="submit">UPLOAD</button>
    </form>




</body>

</html>