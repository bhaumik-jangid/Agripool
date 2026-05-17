<?php

namespace App\Data;

class DistrictData
{
    // Organized by state — districts in alphabetical order within each state
    public static array $stateDistricts = [
        'Gujarat' => [
            'Ahmedabad'           => ['lat' => 23.0225, 'lng' => 72.5714],
            'Amreli'              => ['lat' => 21.6037, 'lng' => 71.2210],
            'Anand'               => ['lat' => 22.5645, 'lng' => 72.9289],
            'Aravalli'            => ['lat' => 23.5800, 'lng' => 73.0100],
            'Banaskantha'         => ['lat' => 24.1700, 'lng' => 72.4300],
            'Bharuch'             => ['lat' => 21.7051, 'lng' => 72.9959],
            'Bhavnagar'           => ['lat' => 21.7645, 'lng' => 72.1519],
            'Botad'               => ['lat' => 22.1693, 'lng' => 71.6653],
            'Chhota Udaipur'      => ['lat' => 22.2970, 'lng' => 74.0110],
            'Dahod'               => ['lat' => 22.8350, 'lng' => 74.2570],
            'Dang'                => ['lat' => 20.7500, 'lng' => 73.6900],
            'Devbhoomi Dwarka'    => ['lat' => 22.2320, 'lng' => 68.9680],
            'Gandhinagar'         => ['lat' => 23.2156, 'lng' => 72.6369],
            'Gir Somnath'         => ['lat' => 20.9000, 'lng' => 70.3700],
            'Jamnagar'            => ['lat' => 22.4707, 'lng' => 70.0577],
            'Junagadh'            => ['lat' => 21.5222, 'lng' => 70.4579],
            'Kheda'               => ['lat' => 22.7500, 'lng' => 72.6800],
            'Kutch'               => ['lat' => 23.7337, 'lng' => 69.8597],
            'Mahisagar'           => ['lat' => 23.0900, 'lng' => 73.5500],
            'Mehsana'             => ['lat' => 23.5880, 'lng' => 72.3693],
            'Morbi'               => ['lat' => 22.8173, 'lng' => 70.8370],
            'Narmada'             => ['lat' => 21.8700, 'lng' => 73.5000],
            'Navsari'             => ['lat' => 20.9467, 'lng' => 72.9520],
            'Panchmahal'          => ['lat' => 22.7200, 'lng' => 73.5200],
            'Patan'               => ['lat' => 23.8493, 'lng' => 72.1266],
            'Porbandar'           => ['lat' => 21.6417, 'lng' => 69.6293],
            'Rajkot'              => ['lat' => 22.3039, 'lng' => 70.8022],
            'Sabarkantha'         => ['lat' => 23.5800, 'lng' => 73.0100],
            'Surat'               => ['lat' => 21.1702, 'lng' => 72.8311],
            'Surendranagar'       => ['lat' => 22.7270, 'lng' => 71.6490],
            'Tapi'                => ['lat' => 21.1200, 'lng' => 73.4100],
            'Vadodara'            => ['lat' => 22.3072, 'lng' => 73.1812],
            'Valsad'              => ['lat' => 20.5992, 'lng' => 72.9342],
        ],
        'Maharashtra' => [
            'Ahmednagar'    => ['lat' => 19.0952, 'lng' => 74.7495],
            'Akola'         => ['lat' => 20.7002, 'lng' => 77.0082],
            'Amravati'      => ['lat' => 20.9374, 'lng' => 77.7796],
            'Aurangabad'    => ['lat' => 19.8762, 'lng' => 75.3433],
            'Beed'          => ['lat' => 18.9891, 'lng' => 75.7601],
            'Bhandara'      => ['lat' => 21.1666, 'lng' => 79.6477],
            'Buldhana'      => ['lat' => 20.5292, 'lng' => 76.1847],
            'Chandrapur'    => ['lat' => 19.9615, 'lng' => 79.2961],
            'Dhule'         => ['lat' => 20.9042, 'lng' => 74.7748],
            'Gadchiroli'    => ['lat' => 20.1809, 'lng' => 80.0000],
            'Gondia'        => ['lat' => 21.4628, 'lng' => 80.1946],
            'Hingoli'       => ['lat' => 19.7173, 'lng' => 77.1490],
            'Jalgaon'       => ['lat' => 21.0077, 'lng' => 75.5626],
            'Jalna'         => ['lat' => 19.8347, 'lng' => 75.8816],
            'Kolhapur'      => ['lat' => 16.6950, 'lng' => 74.2083],
            'Latur'         => ['lat' => 18.4088, 'lng' => 76.5604],
            'Mumbai City'   => ['lat' => 18.9388, 'lng' => 72.8354],
            'Mumbai Suburban'=> ['lat' => 19.0760, 'lng' => 72.8777],
            'Nagpur'        => ['lat' => 21.1458, 'lng' => 79.0882],
            'Nanded'        => ['lat' => 19.1383, 'lng' => 77.3210],
            'Nandurbar'     => ['lat' => 21.3666, 'lng' => 74.2437],
            'Nashik'        => ['lat' => 19.9975, 'lng' => 73.7898],
            'Osmanabad'     => ['lat' => 18.1860, 'lng' => 76.0374],
            'Palghar'       => ['lat' => 19.6967, 'lng' => 72.7697],
            'Parbhani'      => ['lat' => 19.2704, 'lng' => 76.7747],
            'Pune'          => ['lat' => 18.5204, 'lng' => 73.8567],
            'Raigad'        => ['lat' => 18.5158, 'lng' => 73.1810],
            'Ratnagiri'     => ['lat' => 16.9902, 'lng' => 73.3120],
            'Sangli'        => ['lat' => 16.8524, 'lng' => 74.5815],
            'Satara'        => ['lat' => 17.6805, 'lng' => 74.0183],
            'Sindhudurg'    => ['lat' => 16.3500, 'lng' => 73.7333],
            'Solapur'       => ['lat' => 17.6599, 'lng' => 75.9064],
            'Thane'         => ['lat' => 19.2183, 'lng' => 72.9781],
            'Wardha'        => ['lat' => 20.7453, 'lng' => 78.6022],
            'Washim'        => ['lat' => 20.1119, 'lng' => 77.1340],
            'Yavatmal'      => ['lat' => 20.3888, 'lng' => 78.1204],
        ],
        'Rajasthan' => [
            'Ajmer'         => ['lat' => 26.4499, 'lng' => 74.6399],
            'Alwar'         => ['lat' => 27.5530, 'lng' => 76.6346],
            'Banswara'      => ['lat' => 23.5467, 'lng' => 74.4421],
            'Baran'         => ['lat' => 25.1000, 'lng' => 76.5167],
            'Barmer'        => ['lat' => 25.7463, 'lng' => 71.3930],
            'Bharatpur'     => ['lat' => 27.2152, 'lng' => 77.4941],
            'Bhilwara'      => ['lat' => 25.3407, 'lng' => 74.6313],
            'Bikaner'       => ['lat' => 28.0229, 'lng' => 73.3119],
            'Bundi'         => ['lat' => 25.4382, 'lng' => 75.6470],
            'Chittorgarh'   => ['lat' => 24.8887, 'lng' => 74.6269],
            'Churu'         => ['lat' => 28.2982, 'lng' => 74.9679],
            'Dausa'         => ['lat' => 26.8877, 'lng' => 76.3362],
            'Dholpur'       => ['lat' => 26.7006, 'lng' => 77.8943],
            'Dungarpur'     => ['lat' => 23.8434, 'lng' => 73.7171],
            'Hanumangarh'   => ['lat' => 29.5800, 'lng' => 74.3329],
            'Jaipur'        => ['lat' => 26.9124, 'lng' => 75.7873],
            'Jaisalmer'     => ['lat' => 26.9157, 'lng' => 70.9083],
            'Jalore'        => ['lat' => 25.3462, 'lng' => 72.6150],
            'Jhalawar'      => ['lat' => 24.5979, 'lng' => 76.1628],
            'Jhunjhunu'     => ['lat' => 28.1289, 'lng' => 75.3984],
            'Jodhpur'       => ['lat' => 26.2389, 'lng' => 73.0243],
            'Karauli'       => ['lat' => 26.5060, 'lng' => 77.0160],
            'Kota'          => ['lat' => 25.2138, 'lng' => 75.8648],
            'Nagaur'        => ['lat' => 27.2036, 'lng' => 73.7337],
            'Pali'          => ['lat' => 25.7711, 'lng' => 73.3234],
            'Pratapgarh'    => ['lat' => 24.0320, 'lng' => 74.7780],
            'Rajsamand'     => ['lat' => 25.0700, 'lng' => 73.8800],
            'Sawai Madhopur'=> ['lat' => 26.0173, 'lng' => 76.3498],
            'Sikar'         => ['lat' => 27.6094, 'lng' => 75.1398],
            'Sirohi'        => ['lat' => 24.8870, 'lng' => 72.8621],
            'Sri Ganganagar'=> ['lat' => 29.9038, 'lng' => 73.8772],
            'Tonk'          => ['lat' => 26.1664, 'lng' => 75.7895],
            'Udaipur'       => ['lat' => 24.5854, 'lng' => 73.7125],
        ],
        'Punjab' => [
            'Amritsar'      => ['lat' => 31.6340, 'lng' => 74.8723],
            'Barnala'       => ['lat' => 30.3782, 'lng' => 75.5479],
            'Bathinda'      => ['lat' => 30.2110, 'lng' => 74.9455],
            'Faridkot'      => ['lat' => 30.6740, 'lng' => 74.7570],
            'Fatehgarh Sahib'=> ['lat' => 30.6480, 'lng' => 76.3920],
            'Fazilka'       => ['lat' => 30.4020, 'lng' => 74.0290],
            'Ferozepur'     => ['lat' => 30.9236, 'lng' => 74.6200],
            'Gurdaspur'     => ['lat' => 32.0420, 'lng' => 75.4060],
            'Hoshiarpur'    => ['lat' => 31.5143, 'lng' => 75.9115],
            'Jalandhar'     => ['lat' => 31.3260, 'lng' => 75.5762],
            'Kapurthala'    => ['lat' => 31.3780, 'lng' => 75.3800],
            'Ludhiana'      => ['lat' => 30.9010, 'lng' => 75.8573],
            'Mansa'         => ['lat' => 29.9960, 'lng' => 75.3910],
            'Moga'          => ['lat' => 30.8171, 'lng' => 75.1742],
            'Mohali'        => ['lat' => 30.7046, 'lng' => 76.7179],
            'Muktsar'       => ['lat' => 30.4740, 'lng' => 74.5160],
            'Nawanshahr'    => ['lat' => 31.1246, 'lng' => 76.1154],
            'Pathankot'     => ['lat' => 32.2741, 'lng' => 75.6523],
            'Patiala'       => ['lat' => 30.3398, 'lng' => 76.3869],
            'Rupnagar'      => ['lat' => 30.9645, 'lng' => 76.5212],
            'Sangrur'       => ['lat' => 30.2444, 'lng' => 75.8446],
            'Shahid Bhagat Singh Nagar' => ['lat' => 31.1246, 'lng' => 76.1154],
            'Tarn Taran'    => ['lat' => 31.4520, 'lng' => 74.9290],
        ],
        'Madhya Pradesh' => [
            'Agar Malwa'    => ['lat' => 23.7100, 'lng' => 76.0200],
            'Alirajpur'     => ['lat' => 22.3050, 'lng' => 74.3600],
            'Anuppur'       => ['lat' => 23.1040, 'lng' => 81.6890],
            'Ashoknagar'    => ['lat' => 24.5800, 'lng' => 77.7200],
            'Balaghat'      => ['lat' => 21.8130, 'lng' => 80.1860],
            'Barwani'       => ['lat' => 22.0350, 'lng' => 74.9000],
            'Betul'         => ['lat' => 21.9000, 'lng' => 77.9000],
            'Bhind'         => ['lat' => 26.5600, 'lng' => 78.7900],
            'Bhopal'        => ['lat' => 23.2599, 'lng' => 77.4126],
            'Burhanpur'     => ['lat' => 21.3100, 'lng' => 76.2300],
            'Chhatarpur'    => ['lat' => 24.9180, 'lng' => 79.5940],
            'Chhindwara'    => ['lat' => 22.0570, 'lng' => 78.9350],
            'Damoh'         => ['lat' => 23.8300, 'lng' => 79.4400],
            'Datia'         => ['lat' => 25.6700, 'lng' => 78.4700],
            'Dewas'         => ['lat' => 22.9623, 'lng' => 76.0508],
            'Dhar'          => ['lat' => 22.5990, 'lng' => 75.2960],
            'Dindori'       => ['lat' => 22.9500, 'lng' => 81.0800],
            'Guna'          => ['lat' => 24.6474, 'lng' => 77.3152],
            'Gwalior'       => ['lat' => 26.2183, 'lng' => 78.1828],
            'Harda'         => ['lat' => 22.3400, 'lng' => 77.0900],
            'Hoshangabad'   => ['lat' => 22.7500, 'lng' => 77.7200],
            'Indore'        => ['lat' => 22.7196, 'lng' => 75.8577],
            'Jabalpur'      => ['lat' => 23.1815, 'lng' => 79.9864],
            'Jhabua'        => ['lat' => 22.7660, 'lng' => 74.5900],
            'Katni'         => ['lat' => 23.8300, 'lng' => 80.3900],
            'Khandwa'       => ['lat' => 21.8280, 'lng' => 76.3520],
            'Khargone'      => ['lat' => 21.8230, 'lng' => 75.6160],
            'Mandla'        => ['lat' => 22.5980, 'lng' => 80.3740],
            'Mandsaur'      => ['lat' => 24.0730, 'lng' => 75.0690],
            'Morena'        => ['lat' => 26.5000, 'lng' => 78.0000],
            'Narsinghpur'   => ['lat' => 22.9500, 'lng' => 79.1900],
            'Neemuch'       => ['lat' => 24.4760, 'lng' => 74.8690],
            'Niwari'        => ['lat' => 25.0000, 'lng' => 78.9000],
            'Panna'         => ['lat' => 24.7200, 'lng' => 80.1800],
            'Raisen'        => ['lat' => 23.3300, 'lng' => 77.7900],
            'Rajgarh'       => ['lat' => 24.0200, 'lng' => 76.7300],
            'Ratlam'        => ['lat' => 23.3314, 'lng' => 75.0367],
            'Rewa'          => ['lat' => 24.5362, 'lng' => 81.2996],
            'Sagar'         => ['lat' => 23.8388, 'lng' => 78.7378],
            'Satna'         => ['lat' => 24.5800, 'lng' => 80.8300],
            'Sehore'        => ['lat' => 23.2000, 'lng' => 77.0800],
            'Seoni'         => ['lat' => 22.0850, 'lng' => 79.5400],
            'Shahdol'       => ['lat' => 23.2960, 'lng' => 81.3560],
            'Shajapur'      => ['lat' => 23.4270, 'lng' => 76.2770],
            'Sheopur'       => ['lat' => 25.6700, 'lng' => 76.7000],
            'Shivpuri'      => ['lat' => 25.4234, 'lng' => 77.6618],
            'Sidhi'         => ['lat' => 24.4200, 'lng' => 81.8700],
            'Singrauli'     => ['lat' => 24.1990, 'lng' => 82.6760],
            'Tikamgarh'     => ['lat' => 24.7400, 'lng' => 78.8300],
            'Ujjain'        => ['lat' => 23.1828, 'lng' => 75.7772],
            'Umaria'        => ['lat' => 23.5240, 'lng' => 80.8380],
            'Vidisha'       => ['lat' => 23.5250, 'lng' => 77.8140],
        ],
        'Uttar Pradesh' => [
            'Agra'          => ['lat' => 27.1767, 'lng' => 78.0081],
            'Aligarh'       => ['lat' => 27.8974, 'lng' => 78.0880],
            'Prayagraj'     => ['lat' => 25.4358, 'lng' => 81.8463],
            'Ambedkar Nagar'=> ['lat' => 26.4000, 'lng' => 82.5800],
            'Amethi'        => ['lat' => 26.1540, 'lng' => 81.8130],
            'Amroha'        => ['lat' => 28.9040, 'lng' => 78.4680],
            'Auraiya'       => ['lat' => 26.4640, 'lng' => 79.5110],
            'Ayodhya'       => ['lat' => 26.7922, 'lng' => 82.1998],
            'Azamgarh'      => ['lat' => 26.0600, 'lng' => 83.1800],
            'Baghpat'       => ['lat' => 28.9440, 'lng' => 77.2160],
            'Bahraich'      => ['lat' => 27.5700, 'lng' => 81.5900],
            'Ballia'        => ['lat' => 25.7600, 'lng' => 84.1500],
            'Balrampur'     => ['lat' => 27.4200, 'lng' => 82.1800],
            'Banda'         => ['lat' => 25.4800, 'lng' => 80.3400],
            'Barabanki'     => ['lat' => 26.9300, 'lng' => 81.1900],
            'Bareilly'      => ['lat' => 28.3670, 'lng' => 79.4304],
            'Basti'         => ['lat' => 26.7900, 'lng' => 82.7300],
            'Bijnor'        => ['lat' => 29.3700, 'lng' => 78.1400],
            'Budaun'        => ['lat' => 28.0400, 'lng' => 79.1200],
            'Bulandshahr'   => ['lat' => 28.4070, 'lng' => 77.8490],
            'Chandauli'     => ['lat' => 25.2700, 'lng' => 83.2700],
            'Chitrakoot'    => ['lat' => 25.2000, 'lng' => 80.9000],
            'Deoria'        => ['lat' => 26.5000, 'lng' => 83.7800],
            'Etah'          => ['lat' => 27.5600, 'lng' => 78.6600],
            'Etawah'        => ['lat' => 26.7800, 'lng' => 79.0200],
            'Farrukhabad'   => ['lat' => 27.3900, 'lng' => 79.5800],
            'Fatehpur'      => ['lat' => 25.9300, 'lng' => 80.8100],
            'Firozabad'     => ['lat' => 27.1500, 'lng' => 78.4000],
            'Gautam Buddha Nagar' => ['lat' => 28.5355, 'lng' => 77.3910],
            'Ghaziabad'     => ['lat' => 28.6692, 'lng' => 77.4538],
            'Ghazipur'      => ['lat' => 25.5800, 'lng' => 83.5800],
            'Gonda'         => ['lat' => 27.1300, 'lng' => 81.9600],
            'Gorakhpur'     => ['lat' => 26.7606, 'lng' => 83.3732],
            'Hamirpur'      => ['lat' => 25.9500, 'lng' => 80.1500],
            'Hapur'         => ['lat' => 28.7300, 'lng' => 77.7800],
            'Hardoi'        => ['lat' => 27.4100, 'lng' => 80.1300],
            'Hathras'       => ['lat' => 27.5900, 'lng' => 78.0500],
            'Jalaun'        => ['lat' => 26.1500, 'lng' => 79.3400],
            'Jaunpur'       => ['lat' => 25.7300, 'lng' => 82.6800],
            'Jhansi'        => ['lat' => 25.4484, 'lng' => 78.5685],
            'Kannauj'       => ['lat' => 27.0500, 'lng' => 79.9100],
            'Kanpur Dehat'  => ['lat' => 26.4100, 'lng' => 79.9600],
            'Kanpur Nagar'  => ['lat' => 26.4499, 'lng' => 80.3319],
            'Kasganj'       => ['lat' => 27.8100, 'lng' => 78.6400],
            'Kaushambi'     => ['lat' => 25.5200, 'lng' => 81.3800],
            'Kushinagar'    => ['lat' => 26.7400, 'lng' => 83.8900],
            'Lakhimpur Kheri'=> ['lat' => 27.9500, 'lng' => 80.7800],
            'Lalitpur'      => ['lat' => 24.6900, 'lng' => 78.4100],
            'Lucknow'       => ['lat' => 26.8467, 'lng' => 80.9462],
            'Maharajganj'   => ['lat' => 27.1300, 'lng' => 83.5600],
            'Mahoba'        => ['lat' => 25.2900, 'lng' => 79.8700],
            'Mainpuri'      => ['lat' => 27.2300, 'lng' => 79.0200],
            'Mathura'       => ['lat' => 27.4924, 'lng' => 77.6737],
            'Mau'           => ['lat' => 25.9400, 'lng' => 83.5600],
            'Meerut'        => ['lat' => 28.9845, 'lng' => 77.7064],
            'Mirzapur'      => ['lat' => 25.1500, 'lng' => 82.5700],
            'Moradabad'     => ['lat' => 28.8386, 'lng' => 78.7733],
            'Muzaffarnagar' => ['lat' => 29.4727, 'lng' => 77.7085],
            'Pilibhit'      => ['lat' => 28.6400, 'lng' => 79.8000],
            'Pratapgarh'    => ['lat' => 25.9000, 'lng' => 81.9900],
            'Raebareli'     => ['lat' => 26.2300, 'lng' => 81.2400],
            'Rampur'        => ['lat' => 28.8000, 'lng' => 79.0300],
            'Saharanpur'    => ['lat' => 29.9640, 'lng' => 77.5460],
            'Sambhal'       => ['lat' => 28.5900, 'lng' => 78.5700],
            'Sant Kabir Nagar'=> ['lat' => 26.7800, 'lng' => 83.0500],
            'Shahjahanpur'  => ['lat' => 27.8800, 'lng' => 79.9100],
            'Shamli'        => ['lat' => 29.4480, 'lng' => 77.3100],
            'Shrawasti'     => ['lat' => 27.6200, 'lng' => 81.8800],
            'Siddharthnagar'=> ['lat' => 27.2900, 'lng' => 83.0700],
            'Sitapur'       => ['lat' => 27.5700, 'lng' => 80.6800],
            'Sonbhadra'     => ['lat' => 24.6800, 'lng' => 82.7700],
            'Sultanpur'     => ['lat' => 26.2600, 'lng' => 82.0700],
            'Unnao'         => ['lat' => 26.5400, 'lng' => 80.4900],
            'Varanasi'      => ['lat' => 25.3176, 'lng' => 82.9739],
        ],
        'Haryana' => [
            'Ambala'        => ['lat' => 30.3782, 'lng' => 76.7767],
            'Bhiwani'       => ['lat' => 28.7975, 'lng' => 76.1322],
            'Charkhi Dadri' => ['lat' => 28.5920, 'lng' => 76.2680],
            'Faridabad'     => ['lat' => 28.4089, 'lng' => 77.3178],
            'Fatehabad'     => ['lat' => 29.5200, 'lng' => 75.4500],
            'Gurugram'      => ['lat' => 28.4595, 'lng' => 77.0266],
            'Hisar'         => ['lat' => 29.1492, 'lng' => 75.7217],
            'Jhajjar'       => ['lat' => 28.6080, 'lng' => 76.6550],
            'Jind'          => ['lat' => 29.3164, 'lng' => 76.3156],
            'Kaithal'       => ['lat' => 29.8012, 'lng' => 76.3995],
            'Karnal'        => ['lat' => 29.6857, 'lng' => 76.9905],
            'Kurukshetra'   => ['lat' => 29.9695, 'lng' => 76.8783],
            'Mahendragarh'  => ['lat' => 28.2800, 'lng' => 76.1500],
            'Mewat'         => ['lat' => 28.1120, 'lng' => 77.0200],
            'Palwal'        => ['lat' => 28.1440, 'lng' => 77.3330],
            'Panchkula'     => ['lat' => 30.6942, 'lng' => 76.8606],
            'Panipat'       => ['lat' => 29.3909, 'lng' => 76.9635],
            'Rewari'        => ['lat' => 28.1890, 'lng' => 76.6190],
            'Rohtak'        => ['lat' => 28.8955, 'lng' => 76.6066],
            'Sirsa'         => ['lat' => 29.5330, 'lng' => 75.0280],
            'Sonipat'       => ['lat' => 28.9931, 'lng' => 77.0151],
            'Yamunanagar'   => ['lat' => 30.1290, 'lng' => 77.2674],
        ],
        'Karnataka' => [
            'Bagalkot'      => ['lat' => 16.1800, 'lng' => 75.6960],
            'Bangalore Rural'=> ['lat' => 13.0827, 'lng' => 77.5877],
            'Bangalore Urban'=> ['lat' => 12.9716, 'lng' => 77.5946],
            'Belagavi'      => ['lat' => 15.8497, 'lng' => 74.4977],
            'Bellary'       => ['lat' => 15.1394, 'lng' => 76.9214],
            'Bidar'         => ['lat' => 17.9104, 'lng' => 77.5199],
            'Chamarajanagar'=> ['lat' => 11.9219, 'lng' => 76.9454],
            'Chikballapur'  => ['lat' => 13.4355, 'lng' => 77.7315],
            'Chikkamagaluru'=> ['lat' => 13.3161, 'lng' => 75.7720],
            'Chitradurga'   => ['lat' => 14.2299, 'lng' => 76.3980],
            'Dakshina Kannada'=> ['lat' => 12.8438, 'lng' => 75.2479],
            'Davanagere'    => ['lat' => 14.4644, 'lng' => 75.9218],
            'Dharwad'       => ['lat' => 15.4589, 'lng' => 75.0078],
            'Gadag'         => ['lat' => 15.4298, 'lng' => 75.6307],
            'Hassan'        => ['lat' => 13.0068, 'lng' => 76.1003],
            'Haveri'        => ['lat' => 14.7939, 'lng' => 75.3996],
            'Kalaburagi'    => ['lat' => 17.3297, 'lng' => 76.8343],
            'Kodagu'        => ['lat' => 12.3375, 'lng' => 75.8069],
            'Kolar'         => ['lat' => 13.1360, 'lng' => 78.1294],
            'Koppal'        => ['lat' => 15.3508, 'lng' => 76.1547],
            'Mandya'        => ['lat' => 12.5218, 'lng' => 76.8951],
            'Mysuru'        => ['lat' => 12.2958, 'lng' => 76.6394],
            'Raichur'       => ['lat' => 16.2120, 'lng' => 77.3566],
            'Ramanagara'    => ['lat' => 12.7159, 'lng' => 77.2815],
            'Shivamogga'    => ['lat' => 13.9299, 'lng' => 75.5681],
            'Tumkur'        => ['lat' => 13.3409, 'lng' => 77.1010],
            'Udupi'         => ['lat' => 13.3409, 'lng' => 74.7421],
            'Uttara Kannada'=> ['lat' => 14.8600, 'lng' => 74.5800],
            'Vijayapura'    => ['lat' => 16.8302, 'lng' => 75.7100],
            'Yadgir'        => ['lat' => 16.7700, 'lng' => 77.1400],
        ],
        'Tamil Nadu' => [
            'Ariyalur'      => ['lat' => 11.1400, 'lng' => 79.0800],
            'Chengalpattu'  => ['lat' => 12.6920, 'lng' => 79.9757],
            'Chennai'       => ['lat' => 13.0827, 'lng' => 80.2707],
            'Coimbatore'    => ['lat' => 11.0168, 'lng' => 76.9558],
            'Cuddalore'     => ['lat' => 11.7480, 'lng' => 79.7714],
            'Dharmapuri'    => ['lat' => 12.1211, 'lng' => 78.1582],
            'Dindigul'      => ['lat' => 10.3673, 'lng' => 77.9803],
            'Erode'         => ['lat' => 11.3410, 'lng' => 77.7172],
            'Kallakurichi'  => ['lat' => 11.7380, 'lng' => 78.9590],
            'Kancheepuram'  => ['lat' => 12.8333, 'lng' => 79.7000],
            'Kanniyakumari' => ['lat' => 8.0883, 'lng' => 77.5385],
            'Karur'         => ['lat' => 10.9601, 'lng' => 78.0766],
            'Krishnagiri'   => ['lat' => 12.5186, 'lng' => 78.2137],
            'Madurai'       => ['lat' => 9.9252, 'lng' => 78.1198],
            'Mayiladuthurai'=> ['lat' => 11.1034, 'lng' => 79.6534],
            'Nagapattinam'  => ['lat' => 10.7672, 'lng' => 79.8420],
            'Namakkal'      => ['lat' => 11.2190, 'lng' => 78.1672],
            'Nilgiris'      => ['lat' => 11.4916, 'lng' => 76.7337],
            'Perambalur'    => ['lat' => 11.2333, 'lng' => 78.8833],
            'Pudukkottai'   => ['lat' => 10.3797, 'lng' => 78.8260],
            'Ramanathapuram'=> ['lat' => 9.3639, 'lng' => 78.8395],
            'Ranipet'       => ['lat' => 12.9220, 'lng' => 79.3330],
            'Salem'         => ['lat' => 11.6643, 'lng' => 78.1460],
            'Sivaganga'     => ['lat' => 9.8477, 'lng' => 78.4794],
            'Tenkasi'       => ['lat' => 8.9600, 'lng' => 77.3100],
            'Thanjavur'     => ['lat' => 10.7870, 'lng' => 79.1378],
            'Theni'         => ['lat' => 10.0104, 'lng' => 77.4770],
            'Thoothukudi'   => ['lat' => 8.7642, 'lng' => 78.1348],
            'Tiruchirappalli'=> ['lat' => 10.7905, 'lng' => 78.7047],
            'Tirunelveli'   => ['lat' => 8.7139, 'lng' => 77.7567],
            'Tirupathur'    => ['lat' => 12.4950, 'lng' => 78.5680],
            'Tiruppur'      => ['lat' => 11.1085, 'lng' => 77.3411],
            'Tiruvallur'    => ['lat' => 13.1427, 'lng' => 79.9085],
            'Tiruvannamalai'=> ['lat' => 12.2253, 'lng' => 79.0747],
            'Tiruvarur'     => ['lat' => 10.7727, 'lng' => 79.6370],
            'Vellore'       => ['lat' => 12.9165, 'lng' => 79.1325],
            'Viluppuram'    => ['lat' => 11.9401, 'lng' => 79.4861],
            'Virudhunagar'  => ['lat' => 9.5851, 'lng' => 77.9629],
        ],
        'Andhra Pradesh' => [
            'Alluri Sitharama Raju' => ['lat' => 17.8500, 'lng' => 82.0000],
            'Anakapalli'    => ['lat' => 17.6900, 'lng' => 83.0100],
            'Anantapur'     => ['lat' => 14.6819, 'lng' => 77.6006],
            'Bapatla'       => ['lat' => 15.9100, 'lng' => 80.4700],
            'Chittoor'      => ['lat' => 13.2172, 'lng' => 79.1003],
            'Dr. B.R. Ambedkar Konaseema' => ['lat' => 16.8000, 'lng' => 81.8000],
            'East Godavari' => ['lat' => 17.3269, 'lng' => 81.7800],
            'Eluru'         => ['lat' => 16.7107, 'lng' => 81.0952],
            'Guntur'        => ['lat' => 16.3067, 'lng' => 80.4365],
            'Kadapa'        => ['lat' => 14.4673, 'lng' => 78.8242],
            'Kakinada'      => ['lat' => 16.9891, 'lng' => 82.2475],
            'Krishna'       => ['lat' => 16.6100, 'lng' => 80.7200],
            'Kurnool'       => ['lat' => 15.8281, 'lng' => 78.0373],
            'Nandyal'       => ['lat' => 15.4786, 'lng' => 78.4836],
            'NTR'           => ['lat' => 16.5062, 'lng' => 80.6480],
            'Palnadu'       => ['lat' => 16.0200, 'lng' => 79.6400],
            'Prakasam'      => ['lat' => 15.3600, 'lng' => 79.5700],
            'Sri Potti Sriramulu Nellore' => ['lat' => 14.4426, 'lng' => 79.9865],
            'Srikakulam'    => ['lat' => 18.2949, 'lng' => 83.8938],
            'Sri Sathya Sai'=> ['lat' => 14.1700, 'lng' => 77.7800],
            'Tirupati'      => ['lat' => 13.6288, 'lng' => 79.4192],
            'Visakhapatnam' => ['lat' => 17.6868, 'lng' => 83.2185],
            'Vizianagaram'  => ['lat' => 18.1066, 'lng' => 83.3956],
            'West Godavari' => ['lat' => 16.9174, 'lng' => 81.3400],
        ],
    ];

    const RATE_PER_KM_PER_TONNE = 12.0;
    const MINIMUM_CHARGE        = 500.0;
    const TRUCK_CAPACITY_TONNES = 5.0;

    // Get flat districts array for backward compatibility
    public static array $districts = [];

    public static function boot(): void
    {
        if (!empty(self::$districts)) return;
        foreach (self::$stateDistricts as $state => $districts) {
            foreach ($districts as $district => $coords) {
                self::$districts[$district] = array_merge(
                    $coords, ['state' => $state]
                );
            }
        }
    }

    public static function getStates(): array
    {
        return array_keys(self::$stateDistricts);
    }

    public static function getDistrictsForState(string $state): array
    {
        $districts = array_keys(
            self::$stateDistricts[$state] ?? []
        );
        sort($districts); // Alphabetical
        return $districts;
    }

    public static function getDistrictNames(): array
    {
        self::boot();
        $names = array_keys(self::$districts);
        sort($names);
        return $names;
    }

    public static function getStateForDistrict(string $district): string
    {
        self::boot();
        return self::$districts[$district]['state'] ?? '';
    }

    public static function distanceBetween(
        string $fromDistrict,
        string $toDistrict
    ): float {
        self::boot();
        if (!isset(self::$districts[$fromDistrict])
            || !isset(self::$districts[$toDistrict])) {
            return 100;
        }
        $from        = self::$districts[$fromDistrict];
        $to          = self::$districts[$toDistrict];
        $earthRadius = 6371;
        $latDiff     = deg2rad($to['lat'] - $from['lat']);
        $lngDiff     = deg2rad($to['lng'] - $from['lng']);
        $a           = sin($latDiff / 2) * sin($latDiff / 2)
                     + cos(deg2rad($from['lat']))
                     * cos(deg2rad($to['lat']))
                     * sin($lngDiff / 2) * sin($lngDiff / 2);
        return round($earthRadius * 2 * atan2(sqrt($a), sqrt(1 - $a)), 2);
    }

    public static function calculateTruckCost(
        string $fromDistrict,
        string $toDistrict
    ): float {
        $distance = self::distanceBetween($fromDistrict, $toDistrict);
        $cost     = $distance
                  * self::TRUCK_CAPACITY_TONNES
                  * self::RATE_PER_KM_PER_TONNE;
        return max(round($cost, 2), self::MINIMUM_CHARGE);
    }
}