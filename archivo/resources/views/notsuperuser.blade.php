<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Document</title>
</head>
<body class="p-0 m-0">
    <!-- component -->
<div class=" w-screen h-screen   items-center flex justify-center   md:gap-28 gap-16">
    <div class="xl:pt-24 w-full xl:w-1/2 relative pb-12 lg:pb-0">
        <div class="relative">
            <div class="absolute">
                <div class="">
                    <h1 class="my-2 text-gray-800 font-bold text-2xl">
                        Looks like you've found the
                        doorway to the great nothing {{auth()->user()->name}}
                    </h1>
                    <p class="my-2 text-gray-800">Sorry about that! Please visit our hompage to get where you need to go.</p>
                    <button class="sm:w-full lg:w-auto my-2 border rounded md py-4 px-8 text-center bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-700 focus:ring-opacity-50">Take me there!</button>
                </div>
            </div>
            <div>
                <img src="https://i.ibb.co/G9DC8S0/404-2.png" />
            </div>
        </div>
    </div>
    <div>
        <img src="https://i.ibb.co/ck1SGFJ/Group.png" />
    </div>
</div>
</body>
</html>