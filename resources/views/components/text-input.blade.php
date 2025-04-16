@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge([
        'class' =>
        'border-black dark:border-black dark:bg-black dark:text-white
        focus:border-white dark:focus:border-white
        focus:ring-white dark:focus:ring-white
        rounded-md shadow-sm
        px-4 py-3 text-base w-full max-w-xs
        transition duration-200 ease-in-out'
    ]) }}>
