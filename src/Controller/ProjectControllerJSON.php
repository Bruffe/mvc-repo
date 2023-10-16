<?php

namespace App\Controller;

use App\Blackjack\Blackjack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectControllerJSON extends AbstractController
{
    #[Route("/proj/api", name: "proj_api")]
    public function projectAPI(): Response
    {
        return $this->render('project/api.html.twig');
    }

    #[Route('/proj/api/game', name: "proj_api_game")]
    public function projectAPIGameInfo(SessionInterface $session): Response
    {
        if ($session->has("blackJack")) {
            $blackJack = $session->get("blackJack");
        } else {
            $data = [
                "Error message" => "Unable to display information. There is no active game."
            ];

            $response = new JsonResponse($data);
            $response->setEncodingOptions(
                $response->getEncodingOptions() | JSON_PRETTY_PRINT
            );
            return $response;
        }

        $player = [];
        $player["name"] = $blackJack->player->getName();
        for ($i = 0; $i < count($blackJack->player->getHands()); $i++) {
            $player["hand$i"] = [];
            $player["hand$i"]["card-values"] = $blackJack->getPlayerScore($i);
            $player["hand$i"]["score"] = array_sum($blackJack->getPlayerScore($i));
            $player["hand$i"]["bet"] = $blackJack->player->getBets()[$i];
            $player["hand$i"]["winner"] = $blackJack->getWinner($i);
        }
        $player["isStanding"] = $blackJack->player->getStand();

        $dealer = [
            "card-values" => $blackJack->getDealerScore(),
            "score" => array_sum($blackJack->getDealerScore()),
            "isStanding" => $blackJack->dealer->getStand()
        ];

        $data = [
            "player" => $player,
            "dealer" => $dealer
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route('/proj/api/draw', name: "proj_api_draw", methods: ['POST'])]
    public function projectAPIDraw(SessionInterface $session): Response
    {
        if ($session->has("blackJack")) {
            $blackJack = $session->get("blackJack");
        } else {
            $data = [
                "Error message" => "Unable to play on. There is no active game."
            ];

            $response = new JsonResponse($data);
            $response->setEncodingOptions(
                $response->getEncodingOptions() | JSON_PRETTY_PRINT
            );
            return $response;
        }

        $blackJack->play();

        $session->set("blackJack", $blackJack);

        return $this->redirectToRoute('proj_api_game');
    }

    #[Route('/project/api/stand', name: "proj_api_stand", methods: ['POST'])]
    public function projectAPIStand(SessionInterface $session): Response
    {
        if ($session->has("blackJack")) {
            $blackJack = $session->get("blackJack");
            $blackJack->player->incrementCurrentHand();
            $session->set("blackJack", $blackJack);
        } else {
            $data = [
                "Error message" => "Unable to set stand. There is no active game."
            ];

            $response = new JsonResponse($data);
            $response->setEncodingOptions(
                $response->getEncodingOptions() | JSON_PRETTY_PRINT
            );
            return $response;
        }

        return $this->redirectToRoute('proj_api_game');
    }

    #[Route('/proj/api/restart', name: "proj_api_restart", methods: ['POST'])]
    public function projectAPIRestart(
        SessionInterface $session,
        Request $request
    ): Response {
        // set defaults
        $hands = 1;
        $bets = [20];

        // get values from request
        $name = $request->get('api-blackjack-name');
        $hands = (int) $request->get('api-blackjack-hands');
        $bet = (int) $request->get('api-blackjack-bets');

        if ($session->has("blackJack")) {
            $session->remove("blackJack");
        }
        $blackJack = new Blackjack($hands, $name);

        foreach($blackJack->player->getHands() as $hand) {
            $bets[] = $bet;
        }
        $blackJack->player->setBets($bets);

        $session->set("blackJack", $blackJack);

        $data = [
            "name" => $name,
            "hands" => $hands,
            "bets" => $bets
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route('/project/api/cards', name: "proj_api_cards")]
    public function projectAPICards(SessionInterface $session): Response
    {
        if ($session->has("blackJack")) {
            $blackJack = $session->get("blackJack");
        } else {
            $data = [
                "Error message" => "Unable to display cards. There is no active game."
            ];

            $response = new JsonResponse($data);
            $response->setEncodingOptions(
                $response->getEncodingOptions() | JSON_PRETTY_PRINT
            );
            return $response;
        }

        $deck = [
            "amount" => count($blackJack->getDeck()->deck),
            "cards" => $blackJack->getDeck()->getAsStringsNoAlt()
        ];

        $player = [
            "totalAmount" => 0
        ];

        for ($i = 0; $i < count($blackJack->player->getHands()); $i++) {
            $player["hand$i"] = [];
            $player["hand$i"]["amount"] = count($blackJack->player->getHand($i));
            $player["hand$i"]["cards"] = $blackJack->player->getHandObject($i)->getAsStringsNoAlt();
            $player["totalAmount"] += $player["hand$i"]["amount"];
        }

        $dealer = [
            "amount" => count($blackJack->dealer->getHand()),
            "cards" => $blackJack->dealer->getHandObject()->getAsStringsNoAlt()
        ];

        $data = [
            "deck" => $deck,
            "player" => $player,
            "dealer" => $dealer
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
