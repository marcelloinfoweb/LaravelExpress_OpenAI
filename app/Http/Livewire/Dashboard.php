<?php

namespace App\Http\Livewire;

use App\Models\SalesCommission;
use Livewire\Component;
use OpenAI\Laravel\Facades\OpenAI;

class Dashboard extends Component
{
    public array $config;
    public string $question;
    public array $dataset;

    public function render()
    {
        return view('livewire.dashboard');
    }

    protected $rules = ['question' => 'required|min:10'];

    public function generateReport()
    {
        $this->validate();

        $fields = implode(',', SalesCommission::getColumns());
        $question = 'Gere um gráfico das vendas por empresa no eixo y ao longo dos últimos 5 anos';

        $prompt = "Considerando a lista de campos ($fields), e gere uma configuração json do vega-lite v5 ";
        $prompt .= "(sem campo de dados e com descrição) que atenda ao seguinte pedido: $question";

        $config = OpenAI::completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => $prompt,
            'max_tokens' => 1500
        ])->choices[0]->text;

        $this->config = str_replace("\n", "", $this->config);
        $this->config = json_decode($this->config, true);

        $this->dataset = ["values" => SalesCommission::get()->toArray()];

        return $this->config;
    }
}
