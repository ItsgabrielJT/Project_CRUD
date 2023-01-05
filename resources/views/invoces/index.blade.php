@extends('templates.index')

@section('title', 'Invoices')

@section('button-add')
    <a href="{{ route('invoce.create') }}"
        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition mb-4">
        {{ __('Add New') }}
    </a>
@endsection

@section('search')
<div class="max-w-2xl mx-auto">
    <form class="flex items-center" action="{{ route('invoce.index') }}" method="get">
        @csrf
        @method('GET')
        <label for="simple-search" class="sr-only">Search</label>
        <div class="relative w-full">
            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <input type="text" name="texto"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Search" required
                value="{{ $texto }}">
                
        </div>
        <button type="submit"
            class="p-2.5 ml-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><svg
                class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg></button>
    </form>                
</div>
@endsection

@section('table')
<div class="overflow-x-auto">
    <div
        class="min-w-screen bg-gray-100 flex items-center justify-center bg-gray-100 font-sans overflow-hidden">
        <div class="w-full">
            <div class="bg-white shadow-md rounded my-6">
                <table class="min-w-max w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">#Id</th>
                            <th class="py-3 px-6 text-left">Serie</th>
                            <th class="py-3 px-6 text-center">Comprador</th>
                            <th class="py-3 px-6 text-center">Status</th>
                            <th class="py-3 px-6 text-center">Created at</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @if(count($invoces)<=0)
                                <tr>
                                    <td colspan="5" class="py-3 px-6 text-left whitespace-nowrap font-medium"> No hay Resultados </td>
                                </tr>
                            @else
                        @foreach ($invoces as $invoice)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span
                                        class="font-medium">{{ str_pad($invoice->id, 4,0, STR_PAD_LEFT)  }}</span>
                                </div>
                            </td>

                            <td class="py-3 px-6 text-left">
                                <div class="flex items-center">
                                    <span>{{ $invoice->serie }}</span>
                                </div>
                            </td>

                            <td class="py-3 px-6 text-center">
                                <span>{{ $invoice->buyer->nombre }}</span>
                            </td>

                            <td class="py-3 px-6 text-center">
                                <span>{{ $invoice->estatus }}</span>
                            </td>

                            <td class="py-3 px-6 text-center">
                                <span>{{ $invoice->created_at }}</span>
                            </td>

                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <div
                                        class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                        <a
                                            href={{ route('invoce.add_products', ['invoce'=> $invoice->id]) }}>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                height="16" fill="currentColor"
                                                class="bi bi-plus-circle" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                <path
                                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                            </svg>
                                            </svg>
                                        </a>
                                    </div>


                                    {{-- Edit --}}
                                    <div
                                        class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">

                                        <a
                                            href={{ route('invoce.edit', ['invoce'=> $invoice->id]) }}>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                    </div>

                                    <div
                                        class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                        <form method="POST"
                                            action="{{ route('invoce.destroy', ['invoce'=> $invoice->id]) }}">
                                            @csrf
                                            {{  method_field("DELETE") }}

                                            <a href="{{ route('invoce.destroy', ['invoce'=> $invoice->id]) }}"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </a>
                                        </form>

                                    </div>
                                </div>
                            </td>
                        </tr>

                        @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection