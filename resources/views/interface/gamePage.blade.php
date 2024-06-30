@extends('layout.app')


@section('css')
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            font-family: Gotham Rounded;
        }



        .container {
            width: 800px;
            max-width: 80%;
            background-color: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px 2px;
        }

        .btn-grid {
            display: grid;
            grid-template-columns: repeat(2, auto);
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            background-color: hsl(200, 100%, 50%);
            border: 1px solid hsl(200, 100%, 30%);
            border-radius: 5px;
            padding: 5px 10px;
            color: white;
            outline: none;
        }

        .btn:hover {
            border-color: black;
        }

        .flex-container {}

        .screen {
            height: 31vw;

        }

        .insidek {
            color: aqua;
            background-repeat: no-repeat;
            background-position: center;
            background-size: 50%;
            background-image: url({{ asset('asset/1.jpg') }});




        }
    </style>
@endsection

@section('content')
    <div class="flex-container bg-dark outside">
        <div class="screen insidek">
            {{-- <a href="{{route('saveStat',state,)}}" name="save" >save game</a>//state dizisini göndermeye çalış --}}

        </div>

        <div class="container inside">
            <div id="text">Text</div>
            <form id="options-form" method="post" >
                @csrf
              <div id="option-buttons" class="btn-grid">
                    <button class="btn">Option 1</button>
                    <button class="btn">Option 2</button>
                    <button class="btn">Option 3</button>
                    <button class="btn">Option 4</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('gamejs')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        let state = {}

        function goAjax(variable) {
            const id = variable;
            const resturl = "http://127.0.0.1:8001/savedata/" + id;
            $.ajax({
                type: 'get',
                url: resturl,
                dataType: 'json',
                data: {
                    'data': state
                },
                success: function(response) {
                    console.log(response);
                },
            });
        }


        const textElement = document.getElementById('text')
        const optionButtonsElement = document.getElementById('option-buttons')



        function startGame() {
            state = {}
            showTextNode(1)
        }

        function loadGame() {
            state = {}//
            
            showTextNode({{ $node }})
        }

        function showTextNode(textNodeIndex) {
            const textNode = textNodes.find(textNode => textNode.id === textNodeIndex)
            textElement.innerText = textNode.text
            console.log(state);
            while (optionButtonsElement.firstChild) {
                optionButtonsElement.removeChild(optionButtonsElement.firstChild)
            }

            textNode.options.forEach(option => {
                if (showOption(option)) {
                    const button = document.createElement('button')
                    button.innerText = option.text
                    button.classList.add('btn')
                    button.addEventListener('click', () => selectOption(option))
                    optionButtonsElement.appendChild(button)
                    button.value = option.nextText
                    const a = textNode.id
                    button.name = 'selected'
                    button.type = "submit"
                    button.id = 'selectiable'
                    // button.addEventListener('click', goAjax() {
                    //     var id = idInput.value;
                    //     var resturl = "http://127.0.0.1:8001/savedata/" + id;
                    //     $.ajax({
                    //         url: resturl,
                    //         dataType: 'jsonp',
                    //         success: function(data) {
                    //             console.log(data);
                    //         }
                    //     });
                    // })
                    button.onclick = goAjax(a);

                }
            })
        }

        function showOption(option) {
            return option.requiredState == null || option.requiredState(state)
        }

        function selectOption(option) {
            const nextTextNodeId = option.nextText
            if (nextTextNodeId <= 0) {
                return startGame()
            }
            state = Object.assign(state, option.setState)
            showTextNode(nextTextNodeId)
        }



        const textNodes = [{
                id: 1,
                text: 'You wake up in a strange place and place look like a city but there is no one around.',
                options: [{
                        text: 'Look around',
                        nextText: 2
                    },
                    {
                        text: 'Stay where you are',
                        nextText: 3
                    }
                ]
            },
            {
                id: 2,
                text: 'You start walking',
                options: [{
                    text: 'Next',
                    nextText: 4
                }]
            },
            {
                id: 3,
                text: 'You are waiting.',
                options: [{
                    text: 'Next',
                    nextText: 4
                }]
            },
            {
                id: 4,
                text: 'You hear a noise. A man approaches you and asks, "Do you recognize me?"',
                options: [{
                        text: "No, I don't.",
                        nextText: 5
                    },
                    {
                        text: 'Are you Altman?',
                        requiredState: (currentState) => currentState.memory,
                        nextText: 5
                    }
                ]
            },
            {
                id: 5,
                text: "I don't think I've seen you around here. Who are you?",
                options: [{
                        text: "Umm..",
                        nextText: 6
                    },
                    {
                        text: "I don't remember.",
                        nextText: 6
                    },
                    {
                        text: "Dr. Jhon Wilder",
                        requiredState: (currentState) => currentState.memory,
                        nextText: 52
                    },
                    {
                        text: "Dr. Software",
                        requiredState: (currentState) => currentState.DR,
                        nextText: 62
                    }
                ]
            },
            {
                id: 6,
                text: "I see, your cache has been cleared, but no worries. This is a dangerous area, and we need to leave immediately.",
                options: [{
                        text: "Cache... cleared?",
                        nextText: 7
                    },
                    {
                        text: "Leave the area.",
                        nextText: 8
                    }
                ]
            },
            {
                id: 7,
                text: "For people like us, memory is as important as knowing who we are. Our identity doesn't change, but what we do is related to our memory.",
                options: [{
                    text: "Leave the area.",
                    nextText: 8
                }]
            },
            {
                id: 8,
                text: "As you move forward, you see a wall in the middle of the city. As you approach the wall, you hear a loud crash. When you look back, you see a building that wasn't there before.",
                options: [{
                        text: "What is this building?",
                        nextText: 9
                    },
                    {
                        text: "Run",
                        nextText: 10
                    }
                ]
            },
            {
                id: 9,
                text: "It's a long story, but in short, these structures appeared one day. We call them factories. The only difference is that they self-replicate.",
                options: [{
                    text: "Walk towards the wall.",
                    nextText: 10
                }]
            },
            {
                id: 10,
                text: "As you approach the wall, a guard stops you and asks for your identity, but the man behind you says, 'He’s with me.'",
                options: [{
                    text: "Next",
                    nextText: 11
                }]
            },
            {
                id: 11,
                text: "The guard lets you pass and starts chatting with the man.",
                options: [{
                    text: "Next",
                    nextText: 12
                }]
            },
            {
                id: 12,
                text: 'Guard: "Altman, you\'ve managed to return again, and you have someone with you."',
                options: [{
                    text: "Next",
                    nextText: 13
                }]
            },
            {
                id: 13,
                text: "Altman: 'Yes, I found him while exploring the factory boundaries. He's lost his memory.'",
                options: [{
                    text: "Next",
                    nextText: 14
                }]
            },
            {
                id: 14,
                text: 'Guard: "A suicide attempt?"',
                options: [{
                    text: "Next",
                    nextText: 15
                }]
            },
            {
                id: 15,
                text: "Altman: 'I don't know. Anyway, see you.'",
                options: [{
                    text: "Next",
                    nextText: 16
                }]
            },
            {
                id: 16,
                text: "The man you learn is named Altman approaches you and says, 'This is Raid district or what’s left of it. Let me take you to the leader.'",
                options: [{
                    text: "Start walking.",
                    nextText: 17
                }]
            },
            {
                id: 17,
                text: "After walking for a while, you arrive at a headquarters. Inside, there's a table, a woman holding a radio, and a man looking at a map nearby.",
                options: [{
                    text: "Next",
                    nextText: 18
                }]
            },
            {
                id: 18,
                text: "This is our captain. He assembled us, and she is the communication chief, Pilar. The captain speaks strangely, only the chief of communication understands him.",
                options: [{
                    text: "Next",
                    nextText: 19
                }]
            },
            {
                id: 19,
                text: 'Pilar: "Welcome, how are things outside? Please give us good news."',
                options: [{
                        text: "Strange structures were forming.",
                        nextText: 20
                    },
                    {
                        text: 'Unfortunately, the news is bad.',
                        requiredState: (currentState) => currentState.memory,
                        nextText: 20
                    }
                ]
            },
            {
                id: 20,
                text: "Are you talking about the factories? How far were they?",
                options: [{
                    text: "About an hour's walk.",
                    nextText: 21
                }]
            },
            {
                id: 21,
                text: 'Cap: "mov jump write jump jump"',
                options: [{
                    text: "Altman: 'What is the captain saying?'",
                    nextText: 22
                }]
            },
            {
                id: 22,
                text: 'There’s bad news from the north bridge. Do you know what that means?',
                options: [{
                        text: "Yes",
                        nextText: 23
                    },
                    {
                        text: 'No',
                        nextText: 23
                    }
                ]
            },
            {
                id: 23,
                text: "If the north bridge falls, the city falls.",
                options: [{
                    text: "Next",
                    nextText: 24
                }]
            },
            {
                id: 24,
                text: 'Pilar: "Altman, we need you there," and turning to us, she says, "We need all the help we can get."',
                options: [{
                        text: "I can help.",
                        nextText: 25
                    },
                    {
                        text: 'I don’t know how I can help.',
                        nextText: 25
                    }
                ]
            },
            {
                id: 25,
                text: "Rest for today; you'll get your orders tomorrow.",
                options: [{
                    text: "Alright.",
                    nextText: 26
                }]
            },
            {
                id: 26,
                text: 'You leave the headquarters and arrive at a square. Altman points to a building across the way and says you can spend the night there.',
                options: [{
                        text: "Walk to the hotel.",
                        nextText: 29
                    },
                    {
                        text: 'Explore the square.',
                        nextText: 27
                    }
                ]
            },
            {
                id: 27,
                text: 'While exploring, you overhear two children talking.',
                options: [{
                        text: "Approach.",
                        nextText: 28
                    },
                    {
                        text: 'Ignore.',
                        nextText: 29
                    }
                ]
            },
            {
                id: 28,
                text: "Child 1: 'I heard something the other day; there are other universes besides this one.'",
                options: [{
                    text: "Approach closer.",
                    nextText: 30
                }]
            },
            {
                id: 30,
                text: "Child 2: 'Nonsense, how can there be different universes?'",
                options: [{
                    text: "Next",
                    nextText: 31
                }]
            },
            {
                id: 31,
                text: "Actually, we're inside a computer, and we are all software. And our city is actually sick, so a doctor will come and save us.",
                options: [{
                    text: "Software?",
                    setState: {
                        software: true
                    },
                    nextText: 32
                }]
            },
            {
                id: 32,
                text: "You get a headache.",
                options: [{
                    text: "Go to the hotel.",
                    nextText: 29
                }]
            },
            {
                id: 29,
                text: "You enter the hotel and go up to your room. You fall asleep immediately from the day’s exhaustion.",
                options: [{
                    text: "Next",
                    nextText: 33
                }]
            },
            {
                id: 33,
                text: "A woman seems to be approaching you.Darling, are you okay? You fell asleep at the computer again.",
                options: [{
                    text: "Huh?",
                    nextText: 34
                }]
            },
            {
                id: 34,
                text: "Professor, wake up. The system is malfunctioning. You need to get out of there. Wake up!",
                options: [{
                    text: "System, getting out?",
                    nextText: 35
                }]
            },
            {
                id: 35,
                text: 'You wake up as the ground shakes again.',
                options: [{
                        text: "Look out the window.",
                        nextText: 36
                    },
                    {
                        text: 'Go outside.',
                        nextText: 37
                    }
                ]
            },
            {
                id: 36,
                text: "The view hasn’t changed much. You see a familiar woman walking outside",
                options: [{
                    text: "Go outside.",
                    nextText: 39
                }]
            },
            {
                id: 37,
                text: "You see a familiar woman walking outside.",
                options: [{
                    text: "Hey, chief of com, Pilar.",
                    setState: {
                        compilar: true
                    },
                    nextText: 38
                }]
            },
            {
                id: 38,
                text: "She doesn’t seem to hear you, and you start walking towards the headquarters.",
                options: [{
                    text: "Go to the headquarters.",
                    nextText: 40
                }]
            },
            {
                id: 39,
                text: "You go outside, but the woman is gone.",
                options: [{
                    text: "Go to the headquarters.",
                    nextText: 42
                }]
            },
            {
                id: 40,
                text: "While walking, you remember a piece of memory: a woman you recall as your assistant saying, 'Doing something like this is very dangerous.'",
                options: [{
                    text: "Next",
                    nextText: 41
                }]
            },
            {
                id: 41,
                text: "Prof. John Wilder, what if you get stuck in the system or lose some of your data during the transfer? There are too many ....",
                options: [{
                    text: "Next",
                    nextText: 42
                }]
            },
            {
                id: 42,
                text: "You see a commotion inside the headquarters and recognize the captain from afar.",
                options: [{
                    text: "Go to the captain.",
                    nextText: 43
                }]
            },
            {
                id: 43,
                text: 'Cap: "01110110 01101001 01110010 01110101 01110011"',
                options: [{
                        text: "'011101?'",
                        nextText: 44
                    },
                    {
                        text: 'It means virus, right?',
                        requiredState: (currentState) => currentState.compilar,
                        nextText: 44
                    }
                ]
            },
            {
                id: 44,
                text: "You get another headache and faint.",
                options: [{
                        text: "North bridge.",
                        nextText: 45
                    },
                    {
                        text: "Com.Pilar",
                        requiredState: (currentState) => currentState.compilar,
                        nextText: 45
                    },
                    {
                        text: "raid",
                        nextText: 45
                    }
                ]
            },
            {
                id: 45,
                text: "Professor, you finally woke up. Are you okay?",
                options: [{
                    text: "Yes, Ada, I’m fine.",
                    setState: {
                        memory: true
                    },
                    nextText: 46
                }]
            },
            {
                id: 46,
                text: "There was a system error. I couldn't figure out what it was.",
                options: [{
                    text: "I know.",
                    nextText: 47
                }]
            },
            {
                id: 47,
                text: "Ada: 'What do you mean?'",
                options: [{
                    text: "When I transferred my mind to the computer, my cache was cleared.",
                    nextText: 48
                }]
            },
            {
                id: 48,
                text: "Ada: 'PROFESSOR!'",
                options: [{
                    text: "I need to fix this issue and go back in.",
                    nextText: 49
                }]
            },
            {
                id: 49,
                text: "Ada: 'No, you might have been lucky this time, but you might never wake up again.'",
                options: [{
                    text: "Embed the code to stop the virus into the software and let me know when it's ready.",
                    nextText: 50
                }]
            },
            {
                id: 50,
                text: "Three hours later, I’ve set the code, professor. If you're ready, we can start.",
                options: [{
                        text: "I'm ready.",
                        nextText: 1
                    },
                    {
                        text: "I'm not ready. Let’s check one more time.",
                        nextText: 51
                    }
                ]
            },
            {
                id: 51,
                text: "Ada : 'There’s a program in the system called Altman that can help you.'",
                options: [{
                    text: "Thanks.",
                    nextText: 1
                }]
            },
            {
                id: 52,
                text: "I usually have a good memory, but I don’t remember you.",
                options: [{
                    text: "Maybe your cache cleared.",
                    nextText: 53
                }]
            },
            {
                id: 53,
                text: "Huh?",
                options: [{
                    text: "I’m just kidding. You need to help me stop this virus.",
                    nextText: 54
                }]
            },
            {
                id: 54,
                text: "Virus? Help? What is going on?",
                options: [{
                    text: "We need to get into this factory.",
                    nextText: 55
                }]
            },
            {
                id: 55,
                text: "Are you crazy? It can turn us into one of them.",
                options: [{
                    text: "If we act quickly, it won't.",
                    nextText: 56
                }]
            },
            {
                id: 56,
                text: "You enter the factory, but it’s complex and huge.",
                options: [{
                    text: "We need to find a conditional statement that differentiates it from the others.",
                    nextText: 57
                }]
            },
            {
                id: 57,
                text: "Oh. I know where to find it. It sounds like a logical idea. At least it could slow them down.",
                options: [{
                    text: "My goal isn’t to slow it down but to destroy it.",
                    nextText: 58
                }]
            },
            {
                id: 58,
                text: "What do you mean?",
                options: [{
                    text: "I’ll reverse the conditional statement.",
                    nextText: 59
                }]
            },
            {
                id: 59,
                text: "And then?",
                options: [{
                    text: "Then I'll replace the copy operation with a delete operation.",
                    nextText: 60
                }]
            },
            {
                id: 60,
                text: "He points to a room ahead and says, 'The console you need is over there.'",
                options: [{
                    text: "Start the operation.",
                    nextText: 61
                }]
            },
            {
                id: 61,
                text: "The operation was successfully initiated. The factories started self-destructing.",
                options: [{
                    text: "Thank you for playing.",
                    nextText: -1
                }]
            },
            {
                id: 62,
                text: "This is just a legend, a hope that one man would stop this war.",
                options: [{
                    text: "Wow, did you already write a legend about me?",
                    nextText: 53
                }]
            }
        ];

        loadGame()
    </script>
@endsection
