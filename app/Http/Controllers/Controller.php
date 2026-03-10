<?php

/*
 * SINTAXE: namespace
 * SEMÂNTICA: Define o endereço lógico da classe. Todos os controllers da sua aplicação moram aqui.
 */
namespace App\Http\Controllers;

/*
 * SINTAXE: use Caminho\Do\Trait;
 * SEMÂNTICA: Importa "Traits" (características/blocos de código reutilizáveis) do núcleo do Laravel (Foundation).
 * * 1. AuthorizesRequests: Permite que os seus controllers usem métodos como $this->authorize() para 
 * verificar se um usuário tem permissão para fazer algo (usando Gates e Policies).
 * * 2. ValidatesRequests: Permite que você use o $this->validate() diretamente no controller, 
 * facilitando a validação de formulários.
 */
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

/*
 * SINTAXE: use Caminho\Da\Classe as Apelido;
 * SEMÂNTICA: Importa a classe principal de Controller do próprio framework Laravel. 
 * O 'as BaseController' é um "alias" (apelido). Fazemos isso para não dar conflito de nomes, 
 * já que a nossa própria classe abaixo também vai se chamar "Controller".
 */
use Illuminate\Routing\Controller as BaseController;

/*
 * SINTAXE: class Controller extends BaseController
 * SEMÂNTICA: Cria a classe 'Controller' da sua aplicação, herdando toda a lógica central do framework. 
 * É por causa dessa herança que, nos outros arquivos, quando você digita "class CadastroController extends Controller", 
 * o seu CadastroController ganha superpoderes mágicos do Laravel.
 */
class Controller extends BaseController
{
    /*
     * SINTAXE: use Trait1, Trait2;
     * SEMÂNTICA: Injeta os Traits dentro da classe. 
     * Diferente de herança ('extends') onde você só pode ter um "pai", com 'Traits' (use) 
     * você pode pegar métodos de dezenas de arquivos diferentes e "colar" dentro desta classe.
     * Ao fazer isso aqui no Controller Pai, TODOS os controllers filhos do seu projeto ganham as 
     * habilidades de validar requisições e autorizar usuários automaticamente.
     */
    use AuthorizesRequests, ValidatesRequests;
}