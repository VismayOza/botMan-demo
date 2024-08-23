<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Location;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use Illuminate\Support\Facades\Validator;

class BotManController extends Controller
{
    /**
     * Start the botman conversation.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->hears('{message}', function ($botman, $message) {
            $botman->typesAndWaits(2);
            if (strtolower($message) == 'hi' || strtolower($message) == 'hello') {
                $botman->startConversation(new OnboardingConversation);
            } else {
                $botman->reply("Start the conversation using 'hi' or 'hello'...");
            }
        });

        $botman->listen();
    }
}

class OnboardingConversation extends Conversation
{
    /**
     * Ask for the user's name.
     */
    public function startConvoOrnot()
    {
        $this->ask(
            "Hello! Feel free to ask me any questions. If you prefer, I can start by asking you some questions to get to know you better. Type 'you first' to let me start the conversation.",
            function (Answer $answer) {
                $userResponse = strtolower($answer->getText());
                $this->bot->typesAndWaits(2);

                if ($userResponse == 'you first') {
                    $this->askName();
                } else {
                    $this->randomQuestions($userResponse);
                }
            }
        );
    }
    /**
     * Ask for the user's name.
     */
    public function askName()
    {
        $this->ask('Hello! What is your name?', function (Answer $answer) {
            $name = $answer->getText();
            $this->bot->typesAndWaits(2);
            // Validate and sanitize the input
            $validator = Validator::make(['name' => $name], [
                'name' => ['required', 'string', 'regex:/^[\pL\s]+$/u', 'max:255'],
            ]);

            if ($validator->fails()) {
                $this->say('Invalid name. Please try again.');
                return $this->repeat();
            }

            // Check for multiple words or spaces separated
            if (strpos($name, ' ') !== false) {
                $this->say('Please provide only your first name. Try again.');
                return $this->repeat();
            }

            $this->say('Nice to meet you ' . $name . '!');
            $this->askAge();
        });
    }

    /**
     * Ask for the user's age and reply fun answer.
     */
    public function askAge()
    {
        $this->ask('What is your age?', function (Answer $answer) {
            $age = $answer->getText();
            $this->bot->typesAndWaits(2);
            if ($age < 18) {
                $this->say('Seems like you are a child xD');
            } else {
                $this->say('Vote BJP only!');
            }
            $this->askMap();
        });
    }

    /**
     * Ask for the user if he wants to see their location on map.
     */
    public function askMap()
    {
        $this->ask('Do you want to see Your location on map?', function (Answer $answer) {
            $yesOrNo = $answer->getText();
            $this->bot->typesAndWaits(2);
            if (strtolower($yesOrNo) == 'yes') {
                $mapHtml = '
                        <div style="width: 100%; height: 400px;">
                            <iframe 
                                width="100%" 
                                height="100%" 
                                frameborder="0" 
                                style="border:0" 
                                src="' . url('/map') . '" 
                                allowfullscreen>
                            </iframe>
                        </div>
                    ';
                $this->say($mapHtml);
            } else {
                $this->say('Okay, never mind!');
            }
            $this->askPlacesTovisit();
        });
    }

    /**
     * Ask the user if they want to search for nearby places to visit.
     */
    public function askPlacesToVisit()
    {
        $this->ask('Do you want to know the places to Visit in Ahmedabad?', function (Answer $answer) {
            $getAnswer = strtolower($answer->getText());
            $this->bot->typesAndWaits(2);
            if ($getAnswer == 'yes') {
                $this->say('<div class="container">
                            <h4>Places to Visit in Ahmedabad</h4>
                            <ol>
                                <li>Sabarmati Ashram</li>
                                <li>Adalaj Stepwell</li>
                                <li>Hutheesing Jain Temple</li>
                                <li>Kankaria Lake</li>
                                <li>Law Garden</li>
                                <li>Manek Chowk</li>
                            </ol>
                        </div>');
            } else {
                $this->say('Okay, Let me know if you need help from my side anytime!');
            }
        });
    }

    /**
     * Ask the user if they want to search for nearby places to visit.
     */
    public function randomQuestions($answer = null)
    {
        $places = preg_match('/\b(places|Ahmedabad)\b/i', $answer);
        $stockMarket = preg_match('/\bstock\b/i', $answer);
        $shareMarket = preg_match('/\bshare\b/i', $answer);
        $describeIndia = preg_match('/\bindia\b/i', $answer);
        $describeHindustan = preg_match('/\bhindustan\b/i', $answer);
        $whoMade = preg_match('/\b(developed|made)\b/i', $answer);
        $owner = preg_match('/\bowner\b/i', $answer);
        if ($places >= 0 && !empty($places)) {
            $this->say('<div class="container">
                            <h4>Places to Visit in Ahmedabad</h4>
                            <ol>
                                <li>Sabarmati Ashram</li>
                                <li>Adalaj Stepwell</li>
                                <li>Hutheesing Jain Temple</li>
                                <li>Kankaria Lake</li>
                                <li>Law Garden</li>
                                <li>Manek Chowk</li>
                            </ol>
                        </div>');
        } else if (!empty($stockMarket) && ($stockMarket >= 0 || $shareMarket >= 0)) {
            $this->say("The Indian stock market comprises major exchanges like the Bombay Stock Exchange (BSE) and the National Stock Exchange (NSE), offering a diverse range of investment opportunities in one of the world's fastest-growing economies. Tata Motors, a leading Indian automobile manufacturer, is a key player on these exchanges, known for its commercial and passenger vehicles, and has significant global presence through its acquisition of Jaguar Land Rover.");
        } else if (!empty($describeIndia) && ($describeIndia >= 0 || $describeHindustan >= 0)) {
            $this->say("'Hindustan' or 'India' is a historical and cultural term traditionally used to refer to the northern region of the Indian subcontinent, particularly the Indo-Gangetic Plain. It has been used in various contexts to describe the land inhabited predominantly by Hindus, though it also reflects the rich tapestry of diverse cultures, religions, and ethnicities found in India.");
        } else if (!empty($whoMade) && ($whoMade >= 0 || $owner >= 0)) {
            $this->say("Vismay Oza, a PHP Developer has created a demo of the BotMan a chatbot integration.");
        } else {
            $this->say('No result found!');
        }
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->startConvoOrNot();
    }
}
