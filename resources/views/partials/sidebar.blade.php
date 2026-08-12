<!-- Sidebar pour les clients -->
<div class="w-64 bg-white shadow-lg rounded-lg p-6 sticky top-4">
    <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2"> Mon Compte</h3>
    
    <ul class="space-y-3">
        <li>
            <a href="{{ route('panier.voir') }}" class="flex items-center text-gray-700 hover:text-purple-600 font-medium">
                 Mon Panier
                @if(Auth::check() && Auth::user()->paniers()->count() > 0)
                    <span class="ml-2 bg-purple-600 text-white text-xs rounded-full px-2 py-1">
                        {{ Auth::user()->paniers()->count() }}
                    </span>
                @endif
            </a>
        </li>
        
        @auth
            <li>
                <a href="{{ route('profile.edit') }}" class="flex items-center text-gray-700 hover:text-purple-600 font-medium">
                     Mon Profil
                </a>
            </li>
            <li>
                <a href="{{ route('commandes.index') }}" class="flex items-center text-gray-700 hover:text-purple-600 font-medium">
                     Mes Commandes
                </a>
            </li>
            <li>
                <a href="{{ route('avis.index') }}" class="flex items-center text-gray-700 hover:text-purple-600 font-medium">
                     Mes Avis
                </a>
            </li>
            <li class="border-t pt-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center text-red-600 hover:text-red-700 font-medium">
                         Déconnexion
                    </button>
                </form>
            </li>
        @else
            <li>
                <a href="{{ route('login') }}" class="flex items-center text-purple-600 hover:text-purple-700 font-bold">
                     Se connecter
                </a>
            </li>
            <li>
                <a href="{{ route('register') }}" class="flex items-center text-pink-600 hover:text-pink-700 font-bold">
                     S'inscrire
                </a>
            </li>
        @endauth
    </ul>

    <!-- Catégories rapides -->
    <h3 class="text-xl font-bold text-gray-800 mt-6 mb-4 border-b pb-2"> Catégories</h3>
    <ul class="space-y-2">
        @foreach($categories as $cat)
            <li>
                <a href="{{ url('/?categorie=' . $cat->id) }}" class="text-gray-600 hover:text-purple-600 text-sm">
                    {{ $cat->nom }}
                </a>
            </li>
        @endforeach
    </ul>
</div>