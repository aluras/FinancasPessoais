<?php
App::uses('BaseAuthenticate','Controller/Component/Auth');

class OAuth_terceirosAuthenticate extends BaseAuthenticate{

    /**
     * Authenticate a user based on the request information.
     *
     * @param CakeRequest $request Request to get authentication information from.
     * @param CakeResponse $response A response object that can have headers added.
     * @return mixed Either false on failure, or an array of user data on success.
     */
    public function authenticate(CakeRequest $request, CakeResponse $response)
    {
        // TODO: Implement authenticate() method.
        debug($this);
        return true;
    }

    public function getUser(CakeRequest $request)
    {
        //$username = env('PHP_AUTH_USER');
        $username = 'andrelrs80@gmail.com';

        if (empty($username)) {
            return false;
        }
        return $this->_findUser($username);
    }
}