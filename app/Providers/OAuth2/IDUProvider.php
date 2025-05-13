<?php

namespace App\Providers\OAuth2;

use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\InvalidStateException;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class IDUProvider extends AbstractProvider implements ProviderInterface
{
    protected $scopeSeparator = ' ';
    protected $scopes = [];
    protected $urlAuth;
    protected $urlToken;
    protected $urlUserToken;
    protected $urlTokenRevoke;
    protected $urlEndSession;
    protected $accessToken;

    /**
     * Constructor del objeto
     *
     * @param Request $request
     * @param $clientId
     * @param $clientSecret
     * @param $redirectUrl
     * @param $guzzle
     */
    public function __construct(Request $request, $clientId, $clientSecret, $redirectUrl, $guzzle = [])
    {
        parent::__construct($request, $clientId, $clientSecret, $redirectUrl, $guzzle);
        // url base para el archivo de configuración
        $urlBase = config('services.idu.url');
        // permisos de los datos que necesitamos del usuario
        $scopes = config('services.idu.scopes');
        if (!empty($scopes)) {
            $this->scopes = preg_split('/[,+\s]+/', $scopes);
        }
        // accedemos  a la url donde esta la configuración de rutas del OAuth2
        $response = Http::get($urlBase . '/.well-known/openid-configuration');
        // rutas de autorización, token, datos y cierre de sesión
        $this->urlAuth = $response['authorization_endpoint'];
        $this->urlToken = $response['token_endpoint'];
        $this->urlUserToken = $response['userinfo_endpoint'];
        $this->urlTokenRevoke = $response['revocation_endpoint'];
        $this->urlEndSession = $response['end_session_endpoint'];
    }

    /**
     * Método que regresa un objeto de usuario obteniendo la informacion del OAuth
     *
     * @return \Laravel\Socialite\Contracts\User|User|null
     */
    public function user()
    {
        if ($this->user) {
            return $this->user;
        }

        if ($this->hasInvalidState()) {
            throw new InvalidStateException();
        }

        $response = $this->getAccessTokenResponse($this->getCode());
        $this->user = $this->mapUserToObject($this->getUserByToken(
            $token = Arr::get($response, 'access_token')
        ));

        return $this->user->setToken($token)
            ->setRefreshToken(Arr::get($response, 'id_token'))
            ->setExpiresIn(Arr::get($response, 'expires_in'))
            ->setApprovedScopes(explode($this->scopeSeparator, Arr::get($response, 'scope', '')));
    }

    /**
     * Método que invalida el access_token para el sistema
     *
     * @param $token
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getLogoutUrl()
    {
        return $this->urlEndSession;
    }

    /**
     * Método que invalida el access_token para el sistema
     *
     * @param $token
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function revokeToken($token)
    {
        $response = $this->getHttpClient()->post($this->urlTokenRevoke, [
            RequestOptions::HEADERS => [
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode("{$this->clientId}:{$this->clientSecret}"),
            ],
            RequestOptions::FORM_PARAMS => [
                'token' => $token,
            ],
        ]);
        return json_decode((string) $response->getBody(), true);
    }

    /**
     * Get the access token response for the given code.
     *
     * @param  string  $code
     *
     * @return array
     */
    public function getAccessTokenResponse($code)
    {
        $response = $this->getHttpClient()->post($this->getTokenUrl(), [
            RequestOptions::HEADERS => [
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode("{$this->clientId}:{$this->clientSecret}"),
            ],
            RequestOptions::FORM_PARAMS => $this->getTokenFields($code),
        ]);
        return json_decode($response->getBody(), true);
    }

    /**
     * Método que regresa la url para la petición de autorizacion y la concesión de autozación
     *
     * @param $state
     *
     * @return string
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase($this->urlAuth, $state);
    }

    /**
     * Método que regresa la url para obtener el token de acceso (access_token)
     *
     * @return string
     */
    protected function getTokenUrl()
    {
        return $this->urlToken;
    }

    /**
     * Método que regresa un arreglo con los datos del usuario del servidor de recursos
     *
     * @param string $token access_token el token que se nos ha devuelto el servidor de autorización.
     *
     * @return array|mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get($this->urlUserToken, [
            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    /**
     * Método que regresa un objeto genérico de usuario con un arreglo donde se enlaza los datos
     * obtenidos del servidor de recursos y el modelo de usuario/alumno que manejasmos en el sistema de titulación
     *
     * @param array $user
     *
     * @return User
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user);
    }

    /**
     * Get the GET parameters for the code request.
     *
     * @param  string|null  $state
     *
     * @return array
     */
    protected function getCodeFields($state = null)
    {
        $fields = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUrl,
            'scope' => $this->formatScopes($this->getScopes(), $this->scopeSeparator),
            'response_type' => 'code',
        ];

        if ($this->usesState()) {
            $fields['state'] = $state;
            $fields['nonce'] = Str::uuid() . '.' . $state;
        }

        if ($this->usesPKCE()) {
            $fields['code_challenge'] = $this->getCodeChallenge();
            $fields['code_challenge_method'] = $this->getCodeChallengeMethod();
        }

        return array_merge($fields, $this->parameters);
    }

    /**
     * Get the POST fields for the token request.
     *
     * @param  string  $code
     *
     * @return array
     */
    protected function getTokenFields($code)
    {
        $fields = [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $this->redirectUrl,
        ];

        if ($this->usesPKCE()) {
            $fields['code_verifier'] = $this->request->session()->pull('code_verifier');
        }
        return $fields;
    }
}
