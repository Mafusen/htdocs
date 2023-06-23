<?php
    
    //class for å koble til Bring sitt API
    class BringAPI {
        private $api_key;

        //constructorfunksjon som kjører når er ny instans av klassen blir opprettet (i index.php). Setter API-key til min bruker.
        public function __construct($api_key){
            $this->api_key = $api_key;
        }


        //funksjon for å hente ut detaljer fra Bring sitt API. 
        public function getPoststed($postnummer) {
            $url = "https://api.bring.com/shippingguide/api/postalCode.json?clientUrl=dinurl.no&pnr={$postnummer}";

        //oppretter en matrise for å konfigurere HTTP-forespørsel til BringAPI. Setter MyBring login ID og min API key.
        $options = [
            'http' => [
                'header' => "X-MyBring-API-Uid: $this->api_key",
                'method' => 'GET',
            ],
        ];

            //lager et objekt ved hjelp av stream_context_create. Har detaljene fra headeren skapt over.
            $context = stream_context_create($options);
            //leser innholdet i den URL-en til APIet
            $result = file_get_contents($url, false, $context);
            //resultatet kommer tilbake som en json, og dette "oversettes her til et php-array.
            $data = json_decode($result, true);
            //henter ut poststed fra array
            $poststed = $data['result'];

            //returnerer poststed hentet fra metoden
            return $poststed;
        }
    }
?>