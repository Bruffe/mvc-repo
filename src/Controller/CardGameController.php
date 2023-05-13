<?php

namespace App\Controller;

use Exception;
use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Game\CardGame21;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    #[Route("/card", name: "card_start")]
    public function home(): Response
    {
        return $this->render('card/home.html.twig');
    }

    #[Route("/card/deck", name: "card_deck")]
    public function deck(SessionInterface $session): Response
    {
        $deck = new DeckOfCards();

        $session->set("cardIndices", $deck->getIndices());

        $data = [
            "deck" => $deck
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "card_shuffle")]
    public function shuffle(SessionInterface $session): Response
    {
        $deck = new DeckOfCards();
        $deck->shuffle();

        $session->set("cardIndices", $deck->getIndices());

        $data = [
            "deck" => $deck
        ];

        return $this->render('card/shuffle.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "card_draw")]
    public function draw(SessionInterface $session): Response
    {
        $deck = new DeckOfCards();

        if ($session->has("cardIndices")) {
            /** @var int[] $cardIndices */
            $cardIndices = $session->get("cardIndices");
            $deck->setCards($cardIndices);
        }

        if (1 > count($deck->deck)) {
            throw new Exception("Not enough cards left in the deck!");
        }

        $hand = new CardHand();
        $hand->draw($deck, 1);

        $session->set("cardIndices", $deck->getIndices());

        $data = [
            "cardsLeft" => count($deck->deck),
            "hand" => $hand,
            // "hand" => $deck,
            "cardsDrawn" => count($hand->hand)
        ];

        return $this->render('card/draw.html.twig', $data);
    }

    #[Route("/card/deck/draw/{num<\d+>}", name: "card_draw_multiple")]
    public function drawMultiple(SessionInterface $session, int $num): Response
    {
        $deck = new DeckOfCards();

        if ($session->has("cardIndices")) {
            /** @var int[] $cardIndices */
            $cardIndices = $session->get("cardIndices");
            $deck->setCards($cardIndices);
        }

        // $cardIndices = $session->get("cardIndices");

        // $deck = new DeckOfCards();
        // if ($cardIndices)
        // {
        //     $deck->setCards($cardIndices);
        // }

        if ($num > count($deck->deck)) {
            throw new Exception("Not enough cards left in the deck!");
        }

        $hand = new CardHand();
        $hand->draw($deck, $num);

        $session->set("cardIndices", $deck->getIndices());

        $data = [
            "cardsLeft" => count($deck->deck),
            "hand" => $hand,
            // "hand" => $deck,
            "cardsDrawn" => count($hand->hand)
        ];

        return $this->render('card/draw.html.twig', $data);
    }

    #[Route("/game", name: "game_home")]
    public function gameHome(): Response
    {
        return $this->render('game/home.html.twig');
    }

    #[Route("/game/doc", name: "game_doc")]
    public function gameDoc(): Response
    {
        return $this->render('game/doc.html.twig');
    }

    #[Route("/game/play", name: "game_play")]
    public function gamePlay(SessionInterface $session): Response
    {
        if ($session->has("cardGame")) {
            $cardGame = $session->get("cardGame");
            $session->set("cardGame", $cardGame);
        } else {
            $cardGame = new CardGame21();
            $session->set("cardGame", $cardGame);
        }
        
        $data = [
            "testBool" => true,
            // "playerCards" => cardGame->playerCards->hand
            "cardGame" => $cardGame,
            "playerScore" => array_sum($cardGame->getPlayerScore()),
            "dealerScore" => array_sum($cardGame->getDealerScore()),
            "playerPointArray" => $cardGame->getPlayerScore()
        ];

        return $this->render('game/play.html.twig', $data);
    }

    #[Route("/game/draw", name: "game_draw")]
    public function gameDraw(SessionInterface $session): Response
    {
        if ($session->has("cardGame")) {
            $cardGame = $session->get("cardGame");
            // $cardGame->playerDraw();
            $cardGame->play();
            $session->set("cardGame", $cardGame);
        }

        return $this->redirectToRoute('game_play');
    }

    #[Route("/game/stand", name: "game_stand")]
    public function gameStand(SessionInterface $session): Response
    {
        if ($session->has("cardGame")) {
            $cardGame = $session->get("cardGame");
            $cardGame->setPlayerStand();
            $session->set("cardGame", $cardGame);
        }

        return $this->redirectToRoute('game_play');
    }

    #[Route("/game/restart", name: "game_restart")]
    public function gameRestart(SessionInterface $session): Response
    {
        if ($session->has("cardGame")) {
            $session->remove("cardGame");
        }

        return $this->redirectToRoute('game_play');
    }
}
