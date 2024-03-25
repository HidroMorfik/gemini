<?php
use function Livewire\Volt\{state};
use GeminiAPI\Laravel\Facades\Gemini;
use GrahamCampbell\Markdown\Facades\Markdown;

state(['request','result','token']);



$control = function (){
    $this->token = Gemini::countTokens($this->request);
//    $this->result = Gemini::generateText($this->request.'in turkish language');

};


$gemini = function (){
    $this->result = Gemini::generateText($this->request);
    $this->result = Markdown::convert($this->result)->getContent();
    $this->token = false;
};

$iptal = function (){
    $this->token = false;
};



?>
<x-layouts.app>
    @volt
    <main>
        <section class="w-screen grid gap-10">
            <div class="border py-6 px-32 flex flex-col items-center justify-center gap-4">
                <textarea wire:model="request" class="bg-gray-100 px-2 py-3 w-full rounded-xl border-2 " type="text"></textarea>
                <button wire:click="control" class="py-3 bg-green-600 w-1/2 text-white rounded-2xl hover:bg-gray-950">Gönder</button>
            </div>
            <div class="grid gap-16 w-full px-40">
                @if($this->token)
                    <div class="w-full justify-center items-center text-center grid gap-4">
                        <p>Bu işlem {{ $this->token }} tokendır. Devam etmek istediğinize emin misiniz?</p>
                        <div class="flex gap-2 justify-center items-center">
                            <button wire:click="gemini" class="p-2 w-1/2 bg-green-600 text-white rounded-2xl">Evet</button>
                            <button wire:click="iptal" class="p-2 w-1/2 bg-red-600 text-white rounded-2xl">Hayır</button>
                        </div>
                    </div>
                @endif

                    @isset($this->result)
                        <div class="px-10 rounded-md bg-gray-200 p-10 font-semibold shadow-md">
                            <p>
                                {!! $this->result !!}
                            </p>
                        </div>

                    @endisset

            </div>
        </section>


    </main>
    @endvolt


</x-layouts.app>
