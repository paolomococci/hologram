<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EcosystemController extends Controller
{
    /**
     * Ping API
     *
     * example of use:
     * curl --insecure --verbose https://api-agora01.hologram-srv.local/api/ping
     *
     * @return string (JSON)
     */
    public function ping(): string
    {
        return json_encode([
            'status' => Response::HTTP_OK,
            'message' => 'The test endpoint named ping is working!',
        ]);
    }


    /**
     * Stored API
     *
     * example of use:
     * curl --insecure --verbose https://api-agora01.hologram-srv.local/api/stored
     *
     * @return string (JSON)
     */
    public function stored(): string
    {
        return json_encode([
            'status' => Response::HTTP_OK,
            'num' => Posts::count(),
        ]);
    }


    /**
     * Filtered API
     *
     * example of use:
     * curl --insecure --verbose https://api-agora01.hologram-srv.local/api/filtered/caterpillar/1
     *
     * @param string $filter
     * @param integer $current
     * @return string (JSON)
     */
    public function filtered(
        string $filter = "none",
        int $current = 1
    ): string {
        $offset = 10 * ($current - 1);
        if ($filter != 'none') {
            $totalNumberOfPosts = Posts::where('title', 'like', "%$filter%")->with('user')->get()->count();
            $posts = Posts::where('title', 'like', "%$filter%")->with('user')->latest()->offset($offset)->limit(10)->get();
        } else {
            $totalNumberOfPosts = Posts::with('user')->get()->count();
            $posts = Posts::with('user')->latest()->offset($offset)->limit(10)->get();
        }

        return json_encode([
            'status' => Response::HTTP_OK,
            'num' => $totalNumberOfPosts,
            'posts' => $posts
        ]);
    }


    /**
     * Paginate API
     *
     * example of use:
     * curl --insecure --verbose https://api-agora01.hologram-srv.local/api/paginate/1?filter=caterpillar
     *
     * @param integer $current
     * @return string (JSON)
     */
    public function paginate(
        int $current = 1
    ): string {
        $offset = 10 * ($current - 1);
        $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
        if ($filter != '') {
            $totalNumberOfPosts = Posts::where('title', 'like', "%$filter%")->with('user')->get()->count();
            $posts = Posts::where('title', 'like', "%$filter%")->with('user')->latest()->offset($offset)->limit(10)->get();
        } else {
            $totalNumberOfPosts = Posts::with('user')->get()->count();
            $posts = Posts::with('user')->latest()->offset($offset)->limit(10)->get();
        }

        return json_encode([
            'status' => Response::HTTP_OK,
            'num' => $totalNumberOfPosts,
            'posts' => $posts
        ]);
    }
}
