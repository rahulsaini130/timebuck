<?php

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Http\Client;
use Cake\Utility\Security;
use App\Model\Table\TimebuckTable;

class FetchFromAdgatemediaCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io): int
    {
        // $encryptedData = Security::encrypt($dataToEncrypt, Security::getSalt());
        // $decryptedData = Security::decrypt($encryptedData, Security::getSalt());

        $http = new Client();
        $response = $http->get(
            'https://api.adgatemedia.com/v3/offers/',
            [
                'aff' => '48864',
                'api_key' => '155efa664a706f295fb446570041d707',
                'wall_code' => 'o6qb'
            ],
            ['timeout' => 120],
            [
                'headers' => ['Content-Type' => 'application/json']
            ]
        );
        $bodyStream  = $response->getBody();
        $body = $bodyStream->getContents();
        $res = (array) $body;
        $result = json_decode($res[0]);
        
        $TimebuckTable = $this->getTableLocator()->get('timebuck');
        // $a = 1;
        foreach ($result->data as $key => $value) {
            $name = base64_encode(Security::encrypt($value->name, Security::getSalt()));
            $description = base64_encode(Security::encrypt($value->description, Security::getSalt()));
            $requirements = base64_encode(Security::encrypt($value->requirements, Security::getSalt()));
            $click_url = base64_encode(Security::encrypt($value->click_url, Security::getSalt()));

            $Timebuck = $TimebuckTable->newEntity(
                [
                    'name' => $name,
                    'description' => $description,
                    'requirements' => $requirements,
                    'epc' => $value->epc,
                    'click_url' => $click_url,
                ]
            );

            $TimebuckTable->save($Timebuck);

            // $decryptedData = Security::decrypt($name, Security::getSalt());
            // $io->out(($name));
            // if ($a == 30) {
            //     break;
            // }
            // $a++;
        }

        // $io->out(gettype($res));

        return static::CODE_SUCCESS;
    }
}
