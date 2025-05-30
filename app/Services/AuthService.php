<?php

namespace App\Services;

use App\Datasource\NetworkHandler;

class AuthService
{
    protected $serviceUrl;
    protected $authNetwork;

    /**
     * construct
     *
     * @param bool $useCache
     * @param array $headers
     * @param string $apiType
     * @return mixed
     */
    public function __construct(
        $useCache = true,
        $headers = [],
        $apiType = "graphql"
    ) {
        $this->serviceUrl = env(
            "AUTH_API",
            env("SERVICE_BROKER_URL") . "/broker/greep-auth/" . env("APP_STATE")
        );
        $this->authNetwork = new NetworkHandler(
            "",
            $this->serviceUrl,
            $useCache,
            $headers,
            $apiType
        );
    }

    // Authentication routes

    /**
     * Get the authenticated user.
     *
     * @return mixed
     */
    public function authUser()
    {
        return $this->authNetwork->get("/v1/auth/me");
    }
}
