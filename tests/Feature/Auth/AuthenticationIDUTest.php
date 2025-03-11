<?php

namespace Tests\Feature\Auth;

use App\Providers\OAuth2\IDUProvider;
use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\RedirectResponse as HttpRedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Mockery;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Tests\TestCase;

class AuthenticationIDUTest extends TestCase
{
    use DatabaseTransactions;

    public function test_login_screen_can_be_rendered(): void
    {
        $servicesIduSso = config('services.idu.sso');
        Config::set('services.idu.sso', true);

        $response = $this->get('/iniciar-sesion');

        $response->assertStatus(200);
        $response->assertSee('Ingresar con IDU');
        Config::set('services.idu.sso', $servicesIduSso);
    }

    public function test_login_screen_can_not_be_rendered(): void
    {
        $servicesIduSso = config('services.idu.sso');
        Config::set('services.idu.sso', false);

        $response = $this->get('/iniciar-sesion');

        $response->assertStatus(200);
        $response->assertDontSee('Ingresar con IDU');
        Config::set('services.idu.sso', $servicesIduSso);
    }

    public function test_user_can_be_redirected_to_idu(): void
    {
        $servicesIduSso = config('services.idu.sso');
        Config::set('services.idu.sso', true);

        $response = $this->get(route('idu'));

        $response->assertStatus(302);

        Config::set('services.idu.sso', $servicesIduSso);
    }

    public function test_user_can_be_redirected_with_idu(): void
    {
        if (config('services.idu.url')) {
            $request = Request::create('foo');
            $request->setLaravelSession($session = Mockery::mock(Session::class));

            $state = null;
            $closure = function ($name, $stateInput) use (&$state) {
                if ($name === 'state') {
                    $state = $stateInput;

                    return true;
                }

                return false;
            };

            $session->expects('put')->withArgs($closure);
            $provider = new IDUProvider($request, 'client_id', 'client_secret', 'redirect');
            $response = $provider->redirect();

            $nonce = explode('nonce=', $response->getTargetUrl())[1];

            $this->assertInstanceOf(RedirectResponse::class, $response);
            $this->assertInstanceOf(HttpRedirectResponse::class, $response);
            $this->assertSame('https://enigma.unam.mx/sso/oauth2/realms/root/realms/unam/authorize?client_id=client_id&redirect_uri=redirect&scope=openid+profile+roles+email&response_type=code&state='.$state.'&nonce='.$nonce, $response->getTargetUrl());
        } else {
            $this->assertTrue(true);
        }
    }
}
