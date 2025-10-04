<div
    class="bg-[#ffffff] w-full h-14 flex justify-between p-3 shadow-lg max-[768px]:pl-10 max-[768px]:h-10 max-[768px]:p-2">
    <span class="flex">
        <h2 class="text-blue-600 font-bold text-xl">@yield('title', 'Inicio')</h2>
        <h3 class="p-1 font-bold">@yield('subTitle')</h3>
    </span>

    <span class="flex">
        <p class="text-xl font-bold mr-2 max-[768px]:text-lg">10:00 PM</p>
        <button wire:click="logout"
            class="flex justify-end bg-gradient-to-r from-red-600 to-red-700 w-10 h-9 cursor-pointer rounded-md transition duration-200 hover:from-transparent hover:to-transparent hover:bg-red-900 focus:from-transparent focus:to-transparent focus:bg-red-700/30 focus:cursor-progress max-[768px]:-top-1 max-[768px]:h-7.5 max-[768px]:w-8">
            <svg class="w-9 h-9 max-[768px]:h-7 max-[768px]:w-7" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 -960 960 960"fill="#FFFFFF">
                <path
                    d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z" />
            </svg>
        </button>
    </span>
</div>
