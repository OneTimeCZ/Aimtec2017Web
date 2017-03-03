<?php
use Codeception\Util\JsonType;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class ApiTester extends \Codeception\Actor
{
    use _generated\ApiTesterActions;

    public function __construct(Codeception\Scenario $scenario)
    {
        JsonType::addCustomFilter('shortdate', function($value) {
            return preg_match(
                '/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})(\.\d+)?(?:Z|(\+|-)([\d|:]*))?$/',
                $value
            );
        });
        parent::__construct($scenario);
    }

    public function getUserToken($user = null)
    {
        if(!$user)
            $user = factory(App\Models\User::class)->create();

        return JWTAuth::fromUser($user);
    }

    public function loginUser($user = null)
    {
        $token = $this->getUserToken($user);

        $this->haveHttpHeader('Authorization', "Bearer $token");
    }
}
