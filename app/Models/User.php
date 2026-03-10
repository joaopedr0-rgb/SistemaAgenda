<?php

/*
 * SINTAXE: namespace
 * SEMÂNTICA: Define o endereço lógico da classe (App\Models).
 */
namespace App\Models;

// SINTAXE: use
// SEMÂNTICA: Importa as ferramentas necessárias para autenticação, notificações, tokens de API (Sanctum) e fábricas de dados.
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/*
 * SINTAXE: class User extends Authenticatable
 * SEMÂNTICA: A grande diferença! Ao estender 'Authenticatable', esta classe ganha todos os métodos 
 * necessários para o sistema de login (como recuperar a senha criptografada e o identificador da sessão).
 */
class User extends Authenticatable
{
    /*
     * SINTAXE: use Trait1, Trait2, Trait3;
     * SEMÂNTICA: 
     * 1. HasApiTokens: Permite que o usuário gere tokens para APIs (muito usado em Apps Mobile).
     * 2. HasFactory: Permite criar usuários de teste.
     * 3. Notifiable: Permite enviar e-mails de redefinição de senha ou notificações personalizadas.
     */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    /*
     * SINTAXE: protected $fillable = [ array ];
     * SEMÂNTICA: Define quais campos podem ser gravados via formulário. 
     * Você adicionou corretamente o 'is_admin' aqui, permitindo que o sistema defina o nível de acesso no cadastro.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin', // Adicione o campo is_admin à lista de atributos preenchíveis
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    /*
     * SINTAXE: protected $hidden = [ array ];
     * SEMÂNTICA: Segurança de Dados! Quando o Laravel transforma este usuário em um JSON (para uma API, por exemplo), 
     * ele remove automaticamente a senha e o token de "lembrar-me". Isso evita que dados sensíveis vazem acidentalmente.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    /*
     * SINTAXE: protected $casts = [ array ];
     * SEMÂNTICA: Conversão automática de tipos.
     * 1. 'email_verified_at' => 'datetime': Transforma a string do banco em um objeto de data (Carbon).
     * 2. 'password' => 'hashed': Informa ao Laravel que este campo deve ser tratado sempre como uma senha criptografada.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}