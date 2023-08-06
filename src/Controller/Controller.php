<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// class LuckyController
class Controller extends AbstractController
{
    #[Route("/", name: "home")]
    public function home(): Response
    {
        // return new Response(
        //     '<html><body>Hi to you!</body></html>'
        // );

        return $this->render('home.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        // return new Response(
        //     '<html><body>About something!</body></html>'
        // );

        return $this->render('about.html.twig');
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    #[Route('/lucky', name: "lucky")]
    public function number(): Response
    {
        $cpuNumber = random_int(1, 6);
        $pNumber = random_int(1, 6);

        $data =
        [
            "cpu_number" => $cpuNumber,
            "p_number" => $pNumber
        ];
        return $this->render('lucky.html.twig', $data);
        // return new Response(
        //     '<html>
        //         <body>
        //             <h2>Get higher die value than the computer</h2>
        //             <p>The computer got: '.$cpu_number.'</p>
        //             <p>Your die rolled: '.$p_number.'</p>
        //         </body>
        //     </html>'
        // );
    }

    #[Route('/api/quote', name: "quote")]
    public function quote(): Response
    {
        $randomIndex = random_int(0, 2);
        $quotes = [
            "The greatest glory in living lies not in never falling, but in rising every time we fall. -Nelson Mandela",
            "It is during our darkest moments that we must focus to see the light. -Aristotle",
            "Do not go where the path may lead, go instead where there is no path and leave a trail. -Ralph Waldo Emerson"
        ];

        date_default_timezone_set("Europe/Stockholm");

        $data = [
            "quote" => $quotes[$randomIndex],
            "date" => date("Y-m-d", time()),
            "time" => date("H:i:s")
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;

        // return new Response(
        //     '<html><body>Quote: '.$quotes[$random_index].'</body></html>'
        // );
    }

    #[Route("/metrics", name: "metrics")]
    public function metrics(): Response
    {
        return $this->render('metrics.html.twig');
    }
}
