<?php
for (
    $i = 0; //inisialisasi indeks php dimulai dari 0 
    $i < 10; //kondisi terminasi
    $i++
) {
    print "halo world <br> ";
}

//cek dulu kondisinya, selama kondisinya bernilai true maka bisa dilakukakn dengan while
$i = 0;
while (
    $i < 10
) {
    echo "$i <br>";
    $i++;
}

//jalankan dulu sintaksnya lalu cek kondisinya bernilai true 
$i = 0;
do {
    echo " hello world  <br>";
    $i++;
} while ($i < 5);
