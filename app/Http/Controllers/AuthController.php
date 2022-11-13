<?php
namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/**
 * @RestController
 * @ApiOperation("Products API")
 */
class AuthController extends Controller
{
    /**
    * Create a new AuthController instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/api/auth/login",
     *     tags={"Auth"},
     *     summary="Login",
     *     description="Do Login",
     *     operationId="login",
     *
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     ),
     *     @OA\RequestBody(
     *         description="Create user object",
     *       @OA\JsonContent(
     *       required={"email", "password"},
     *       @OA\Property(property="email", type="email", format="text", example="mercedes68@example.org"),
     *       @OA\Property(property="password", type="string", format="text", example="123456"),
     *    )),
     * )
     */
    public function login(): JsonResponse
    {
        $credentials = request(['email', 'password']);

        try {
            $token = auth()->attempt($credentials);
        } catch (\Throwable $exception) {
            dd($exception->getMessage());
        }


        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     *
     * @OA\Post(
     *     path="/api/auth/me",
     *     tags={"Auth"},
     *     summary="Get current user for REST API",
     *     description="Multiple status values can be provided with comma separated string",
     *     operationId="me",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     )
     * )
    */
    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     *
     * /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     tags={"Auth"},
     *     summary="Logout",
     *     description="This can only be done by the logged in user.",
     *     operationId="logout",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     * )
    */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     * /**
     * @OA\Post(
     *     path="/api/auth/refresh",
     *     tags={"Auth"},
     *     summary="Logout",
     *     description="This can only be done by the logged in user.",
     *     operationId="refresh",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     * )
    */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
    */
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
