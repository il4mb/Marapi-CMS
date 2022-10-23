<?php
namespace Module\classes;
#  ENCH - encrypt and decrypt string
#       -- create by ilham b --
#        don`t edit this file

class ENCH {
    private $string;
    private $keysManager;

    public final function __construct($string) {
        $this->keysManager = new keysManager();

        $this->string = $string;
    }

    public function decrypt() {
        $keypos = unpack("C*", substr($this->string, 0, 1))[1];
        $key = $this->keysManager->getByKey($keypos);
        $keyLength = strlen($key);
        $binaryKey = unpack("C*", $key);
        $binaryStr = unpack("C*", $this->string);

        $binaryStr = unpack("C*", substr($this->string, 1, strlen($this->string)));

        $output = [];
        $counter = 0;
        foreach($binaryStr AS $keys => $bin) {
            $counter++;
            $output[$keys] = (($bin - $binaryKey[$counter]));
            if($counter == $keyLength)
                $counter = 0;
        }
        return json_decode(pack("C*", ...$output));
    }
    public function encrypt() {
        $keypos = $this->keysManager->getRandomKey();
        $key = $this->keysManager->getByKey($keypos);
        $keyLength = strlen($key);
        $binaryKey = unpack("C*", $key);

        $binaryStr = unpack("C*", json_encode($this->string));

        $output = [];
        $counter = 0;
        foreach($binaryStr AS $keys => $bin) {
            $counter++;
            $output[$keys] = (($bin + $binaryKey[$counter]));
            if($counter == $keyLength)
                $counter = 0;
        }
        return pack("C*", ...[$keypos]).pack("C*", ...$output);
    }
}

class keysManager {
    private $list = ["Alligator", "Albatros", "Alpaka", "Ular anaconda", "Ikan teri", "Anoa", "Semut", "Trenggiling", "Antelop", "Kera", "Babon", "Luwak", "Kelelawar", "Biwara", "Lebah", "Kumbang", "Burung", "Bison", "Ular boa", "Babi hutan", "Kucing hutan", "Banteng", "Anjing Bulldog", "Kupu-kupu", "Rajawali", "Anak sapi", "Unta", "Kenari", "Kasuari", "Kucing", "Ulat bulu", "Lele", "Kelabang", "Bunglon", "Ayam", "Simpanse", "Tupai tanah", "Kerang", "Tongkol", "Ular kobra", "Kakatua", "Kecoa", "Sapi", "Anjing hutan", "Kepiting", "Jangkrik", "Buaya", "Gagak", "Kuskus", "Rusa", "Anjing", "Lumba-Lumba", "Keledai", "Burung Dara","Capung", "Bebek", "Elang", "Belut", "Gajah", "Rusa besar", "Falkon", "Kunang-Kunang", "Ikan", "Flamingo", "Kutu", "Lalat", "Laron", "Rubah", "Katak", "Cicak", "Siamang", "Jerapah", "Kambing", "Soang", "Belalang", "Belibis", "Marmut", "Hamster", "Elang",  "Ayam betina", "Bangau", "Kuda nil", "Rangkong", "Tabuhan", "Kuda", "Kolibri", "Iguana", "Jaguar", "Ubur-Ubur", "Kanguru",  "Anak kucing", "Burung kiwi", "Koala", "Komodo", "Kepik", "Anak domba", "Lutung", "Lintah", "Macan tutul", "Kutu rambut", "Singa",  "Kadal", "Llama", "Lobster", "Belatung", "Murai", "Maleo", "Mamut", "Belalang Sembah", "Bandeng", "Monyet", "Nyamuk", "Ngengat",  "Tikus", "Kancil", "Remis", "Kadal air", "Bulbul", "Gurita", "Burung unta", "Berang-berang", "Burung hantu", "Kerbau", "Tiram",  "Panda", "Harimau Kumbang", "Beo", "Ayam Hutan", "Merak", "Pelikan", "Babi", "Merpati", "Platipus", "Beruang kutub", "Landak",  "Anak anjing", "Ular piton", "Puyuh", "Kelinci", "Tikus besar", "Ular derik", "Gagak besar", "Badak", "Ayam jantan", "Salamander",  "Sarden", "Kalajengking", "Singa laut", "Burung camar", "Kuda laut", "Anjing laut", "Hiu", "Domba", "Udang", "Kukang", "Siput",  "Ular", "Kakap", "Burung gereja", "Laba-laba", "Cumi-cumi", "Tupai", "Bintang laut", "Ikan pari", "Cerpelai", "Burung layang",  "Angsa putih", "Ikan cucut", "Kecebong", "Tarantula", "Mujair", "Rayap", "Harimau", "Kodok", "Kura-kura", "Ikan tuna", "Kalkun", "Penyu", "Perkutut", "Ular berbisa", "Burung bangkai", "Singa Laut", "Tawon", "Musang", "Paus", "Serigala", "Burung pelatuk", "Cacing", "Zebra"];
    public function __construct() {
    }
    public function getByKey(int $key) {
        return $this->list[$key];
    }
    public function getRandomKey() {
        return array_rand($this->list);
    }
}