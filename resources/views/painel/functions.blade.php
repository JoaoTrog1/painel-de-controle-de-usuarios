@extends('app')

@section('actionheader')
    <a href="{{ route('painel.logout') }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
        </svg>
    </a>
@endsection

@section('conteudo')

    <div class="flex flex-col w-full h-full p-4 items-center">
            
        <div class="flex w-full">
            <a href="{{ route('users.index', $admin->id) }}" class="flex items-center py-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-bar-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12.5 15a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5M10 8a.5.5 0 0 1-.5.5H3.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L3.707 7.5H9.5a.5.5 0 0 1 .5.5"/>
                </svg>
                Back to Home
            </a>
        </div>

        

        <div class="flex flex-col w-[90%] max-w-[500px] mt-4">

            @if (isset($appName))
            <div class="flex mb-4 w-full flex-col">
                <form method="POST" action="{{ route('painel.functions.appname', $admin->id) }}" class="flex w-full">
                    @csrf
                    <input name="name" type="text" value="{{$appName}}" class="flex flex-grow p-2 border rounded mr-2" placeholder="App name">
                    <button type="submit" class="px-4 bg-blue-500 text-white rounded">SAVE</button>
                </form>
            </div>
            @endif
    
            <h1 class="mb-2 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl truncate">
                Funções
            </h1>
                
            <form action="{{ route('painel.functions.store', $admin->id) }}" method="POST" class="flex flex-col shadow-2xl bg-white rounded-md p-5 space-y-4">
                @csrf
                @if (isset($editViewData) && is_object($editViewData))
                    <input type="hidden" name="id" value="{{ $editViewData->id }}">
                @endif

                <select id="typeSelect" name="type" class="rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5" required>
                    <option value="TEXT" @if (isset($editViewData) && $editViewData->type == 'TEXT') selected @endif>Texto</option>
                    <option value="SWITCH" @if (isset($editViewData) && $editViewData->type == 'SWITCH') selected @endif>Switch</option>
                    <option value="SEEKBAR" @if (isset($editViewData) && $editViewData->type == 'SEEKBAR') selected @endif>SeekBar</option>
                    <option value="BUTTON" @if (isset($editViewData) && $editViewData->type == 'BUTTON') selected @endif>Button</option>
                </select>

                <input type="text" name="content" value="{{ $editViewData->content ?? '' }}" placeholder="Content" class="rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5" required>
    
                <input id="linkField" type="text" name="link" value="{{ $editViewData->link ?? '' }}" placeholder="Enter link" class="rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 hidden" required>
  
                <div id="rangeFields" class="flex space-x-2 mt-2">
                    <input type="number" name="min" value="{{ $editViewData->min ?? 0 }}" class="rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5">
                    <input type="number" name="max" value="{{ $editViewData->max ?? 100 }}" class="rounded-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5">
                </div>
            
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center">
                    Save
                </button>
            </form>
            
            

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif


            <div class="container mt-5">
                <div class="relative overflow-x-auto shadow-2xl rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="p-2">
                                    Type
                                </th>
                                <th scope="col" class="p-2">
                                    Content
                                </th>
                                <th scope="col" class="p-2 text-right">
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($viewData as $data)
                            <tr class="bg-white hover:bg-gray-50 ">
                                <th scope="row" class="p-2 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $data->type }}
                                </th>
                                <td class="p-2">
                                    {{ $data->content }}
                                </td>
                                <td class="p-2 text-right">
                                    <div class="flex items-center space-x-4 ">
                                        <p class="flex flex-grow"></p>
                                        <a href="{{ route('painel.functions.edit', [$admin->id, $data->id], ) }}" 
                                            class="inline-block font-medium text-blue-600 hover:underline">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('painel.functions.delete', [$admin->id, $data->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Tem certeza que deseja excluir {{ $data->type }}?')"
                                                class="text-red-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>    
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const typeSelect = document.getElementById('typeSelect');
            const linkField = document.getElementById('linkField');
    
            const toggleLinkField = () => {
                if (typeSelect.value === 'BUTTON') {
                    linkField.classList.remove('hidden');
                    
                } else {
                    linkField.classList.add('hidden');
                }
                linkField.value = 'https://'
            };
            toggleLinkField();
    
            typeSelect.addEventListener('change', toggleLinkField);
        });
    </script>
@endsection
