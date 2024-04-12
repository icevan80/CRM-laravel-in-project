<?php

namespace App\Http\Livewire\Settings;

use Illuminate\Support\Facades\App;
use Livewire\Component;

class Translations extends Component
{

    public string $current_lang;
    public string $temp_lang;
    public string $path = '';
    public array $parsedTranslation = array();
    public array $translations = array();
    public bool $notificationChangesComplete = false;
    public bool $createNewTranslation = false;
    public string $code = '';
    public string $name = '';


    public function mount()
    {
        $this->getTranslationList();

        $this->temp_lang = $this->current_lang = App::currentLocale();
        $this->path = resource_path('/lang/' . $this->current_lang . '.json');
        $this->readTranslationConfig();
    }

    public function getTranslationList()
    {
        $this->translations = array();
        foreach (scandir(resource_path('/lang/')) as $fileName) {
            $code = explode(".json", $fileName)[0];
            if ($code == '.' || $code == '..') {
                continue;
            }
            $this->translations[] = $code;
        }
    }

    public function render()
    {
        if (count($this->translations) + 2 != count(scandir(resource_path('/lang/')))) {
            $this->getTranslationList();
        }
        return view('livewire.settings.translations', [
            'parsedTranslation' => $this->parsedTranslation,
            'translations' => $this->translations
        ]);
    }

    public function changeTranslation(string $translationCode)
    {
        $this->path = resource_path('/lang/' . $translationCode . '.json');
        $this->readTranslationConfig();
        $this->current_lang = $translationCode;

        $this->approveChangeTranslation = false;
    }

    public function readTranslationConfig()
    {
        $this->parsedTranslation = array();
        $file = file_get_contents($this->path);
        $jsonArray = json_decode($file, true);
        foreach (array_keys($jsonArray) as $key) {
            $this->parsedTranslation[$key] = array('key' => $key, 'value' => $jsonArray[$key]);
        }
    }

    public function saveTranslationConfig()
    {
        $jsonArray = array();
        foreach ($this->parsedTranslation as $translation) {
            $jsonArray[$translation['key']] = $translation['value'];
        }
        $jsonString = utf8_encode(json_encode($jsonArray, JSON_PRETTY_PRINT));
        $fp = fopen($this->path, 'w');
        fwrite($fp, $jsonString);
        fclose($fp);
        $this->notificationChangesComplete = true;
    }

    public function syncTranslationKeys(bool $save = false)
    {
        $file = file_get_contents(resource_path('/lang/en.json'));
        $jsonArray = json_decode($file, true);
        foreach (array_keys($jsonArray) as $key) {
            if (!array_key_exists($key, $this->parsedTranslation)) {
                $this->parsedTranslation[$key] = array('key' => $key, 'value' => $jsonArray[$key]);
            }
        }

        if ($save) {
            $this->saveTranslationConfig();
        } else {
            $this->notificationChangesComplete = true;
        }
    }

    public function createNewTranslation(string $code, string $name)
    {
        $file = file_get_contents(resource_path('/lang/en.json'));
        $jsonArray = json_decode($file, true);
        $jsonArray[$code] = $name;
        $jsonString = utf8_encode(json_encode($jsonArray, JSON_PRETTY_PRINT));
        $newFile = fopen(resource_path('/lang/' . $code . '.json'), "w");
        fwrite($newFile, $jsonString);
        fclose($newFile);
        $rewriteFile = fopen(resource_path('/lang/en.json'), "w");
        fwrite($rewriteFile, $jsonString);
        fclose($rewriteFile);
        $this->syncTranslationKeys(true);
        $this->code = $this->name = '';
        $this->createNewTranslation = false;
    }
}
