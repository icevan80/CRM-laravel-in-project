<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class TranslationSettings extends Component
{

    public string $current_lang;
    public string $temp_lang;
    public string $path = '';
    public array $parsedTranslation = array();
    public bool $notificationChangesComplete = false;


    public function mount()
    {
        $this->temp_lang = $this->current_lang = App::currentLocale();
        $this->path = resource_path('/lang/'.$this->current_lang.'.json');
        $this->readTranslationConfig();
    }

    public function render()
    {
        return view('livewire.translation-settings', ['parsedTranslation' => $this->parsedTranslation]);
    }

    public function changeTranslation(string $translationCode) {
        $this->path = resource_path('/lang/'.$translationCode.'.json');
        $this->readTranslationConfig();
        $this->current_lang = $translationCode;

        $this->approveChangeTranslation = false;
    }

    public function readTranslationConfig() {
        $this->parsedTranslation = array();
        $file = file_get_contents($this->path);
        $jsonArray = json_decode($file, true);
        foreach (array_keys($jsonArray) as $key) {
            $this->parsedTranslation[$key] = array('key' => $key, 'value' => $jsonArray[$key]);
        }
    }

    public function saveTranslationConfig() {
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
}
