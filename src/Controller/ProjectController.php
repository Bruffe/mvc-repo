<?php

namespace App\Controller;

use App\Blackjack\Blackjack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    #[Route("/proj/about", name: "proj_about")]
    public function projectAbout(): Response
    {
        return $this->render('project/about.html.twig');
    }

    #[Route("/proj/start-game", name: "proj_start_game")]
    public function projectStartGame(
        SessionInterface $session
    ): Response
    {
        $data = [
            "playerName" => ""
        ];

        if ($session->has("blackJackDetails")) {
            $blackJackDetails = $session->get("blackJackDetails");
            // echo($blackJackDetails['money']);

            $data = [
                "playerName" => $blackJackDetails["playerName"]
            ];
        }
        return $this->render('project/start.html.twig', $data);
    }

    #[Route("/proj/init-game", name: "proj_init_game", methods: ['POST'])]
    public function projectInitGame(
        SessionInterface $session,
        Request $request
    ): Response
    {
        $playerName = $request->get('player-name');
        $handAmount = $request->get('hands');

        $session->set('player_name', $playerName);
        $session->set('hands', $handAmount);

        $blackJack = new Blackjack($session->get('hands'), $session->get('player_name'));
        
        if ($session->has("blackJackDetails")) {
            $blackJackDetails = $session->get("blackJackDetails");

            $blackJack->player->setMoney($blackJackDetails["money"]);
        }

        $session->set("blackJack", $blackJack);

        return $this->redirectToRoute('proj_bet');
    }

    #[Route("/proj/play-game", name: "proj_play_game")]
    public function projectPlayGame(SessionInterface $session): Response
    {
        if ($session->has("blackJack")) {
            $blackJack = $session->get("blackJack");
        }

        $data = [
            "playerName" => $session->get('player_name'),
            "hands" => $session->get('hands'),
            "blackJack" => $blackJack
        ];

        return $this->render('project/play.html.twig', $data);
    }

    #[Route("/proj/draw", name: "proj_draw")]
    public function projectDraw(SessionInterface $session): Response
    {
        if ($session->has("blackJack")) {
            $blackJack = $session->get("blackJack");
            $blackJack->play();
            $session->set("blackJack", $blackJack);
        }

        return $this->redirectToRoute('proj_play_game');
    }

    #[Route("/proj/stand", name: "proj_stand")]
    public function projectStand(SessionInterface $session): Response
    {
        if ($session->has("blackJack")) {
            $blackJack = $session->get("blackJack");
            $blackJack->player->incrementCurrentHand();
            $session->set("blackJack", $blackJack);
        }

        return $this->redirectToRoute('proj_play_game');
    }

    #[Route("/proj/restart-game", name: "proj_restart_game")]
    public function projectRestartGame(SessionInterface $session): Response
    {
        if ($session->has("blackJack")) {
            $session->remove("blackJack");
        }

        if ($session->has("blackJackDetails")) {
            $session->remove("blackJackDetails");
        }

        return $this->redirectToRoute('proj_start_game');
    }

    #[Route("/proj/bet", name: "proj_bet")]
    public function projectBet(SessionInterface $session): Response
    {
        $hands = $session->get("hands");
        $blackJack = $session->get("blackJack");
        $data = [
            "hands" => $hands,
            "money" => $blackJack->player->getMoney()
        ];

        return $this->render('project/bet.html.twig', $data);
    }

    #[Route("/proj/process-bet", name: "proj_process_bet", methods: ['POST'])]
    public function projectProcessBet(
        SessionInterface $session,
        Request $request
    ): Response
    {
        $bets[] = $request->get("bet1");

        if ($request->request->has("bet2")) {
            $bets[] = $request->get("bet2");
        }

        if ($request->request->has("bet3")) {
            $bets[] = $request->get("bet3");
        }

        // $blackJack = new Blackjack($session->get('hands'), $session->get('player_name'));
        // if ($session->has("blackJack")) {
        //     $blackJack = $session->get("blackJack");
        // }
        $blackJack = $session->get("blackJack");
        if (!$blackJack->player->canAffordBet($bets)) {
            return $this->redirectToRoute('proj_bet');
        }
        $blackJack->player->setBets($bets);
        $session->set("blackJack", $blackJack);

        return $this->redirectToRoute('proj_play_game');
    }

    #[Route("/proj/continue-game", name: "proj_continue")]
    public function projectContinueGame(SessionInterface $session): Response
    {
        if ($session->has("blackJack")) {
            $blackJack = $session->get("blackJack");
            $money = $blackJack->player->getMoney();
            $handAmount = count($blackJack->player->getHands());
            $playerName = $blackJack->player->getName();
            $session->remove("blackJack");

            $blackJackDetails = [
                "money" => $money,
                "playerName" => $playerName
            ];
            $session->set("blackJackDetails", $blackJackDetails);
        }

        return $this->redirectToRoute('proj_start_game');
    }
}
