<template>
  <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <router-link to="/" class="flex items-center space-x-3">
          <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-lg flex items-center justify-center">
            <ChefHat :size="24" class="text-white" />
          </div>
          <span class="text-xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">
            RecipeHub
          </span>
        </router-link>
        
        <div v-if="authStore.isAuthenticated" class="flex items-center space-x-6">
          <router-link 
            to="/recipes" 
            class="flex items-center space-x-2 text-gray-700 hover:text-orange-600 transition-colors font-medium"
          >
            <BookOpen :size="20" />
            <span>Receitas</span>
          </router-link>
          
          <router-link 
            to="/recipes/create" 
            class="flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-orange-500 to-red-600 text-white rounded-lg hover:from-orange-600 hover:to-red-700 transition-all shadow-md hover:shadow-lg"
          >
            <Plus :size="20" />
            <span>Nova Receita</span>
          </router-link>

          <div class="flex items-center space-x-3 pl-6 border-l border-gray-200">
            <div class="flex items-center space-x-2">
              <div class="w-8 h-8 bg-gradient-to-br from-orange-400 to-red-500 rounded-full flex items-center justify-center">
                <User :size="16" class="text-white" />
              </div>
              <span class="text-sm font-medium text-gray-700">{{ authStore.user?.name }}</span>
            </div>
            
            <button
              @click="handleLogout"
              class="flex items-center space-x-2 px-3 py-2 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
            >
              <LogOut :size="18" />
              <span class="text-sm font-medium">Sair</span>
            </button>
          </div>
        </div>

        <div v-else class="flex items-center space-x-3">
          <router-link 
            to="/login" 
            class="flex items-center space-x-2 px-4 py-2 text-gray-700 hover:text-orange-600 font-medium transition-colors"
          >
            <LogIn :size="20" />
            <span>Entrar</span>
          </router-link>
          <router-link 
            to="/register" 
            class="flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-orange-500 to-red-600 text-white rounded-lg hover:from-orange-600 hover:to-red-700 transition-all shadow-md hover:shadow-lg"
          >
            <UserPlus :size="20" />
            <span>Cadastrar</span>
          </router-link>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import { ChefHat, BookOpen, Plus, User, LogOut, LogIn, UserPlus } from 'lucide-vue-next';

export default {
  name: 'NavBar',
  components: {
    ChefHat,
    BookOpen,
    Plus,
    User,
    LogOut,
    LogIn,
    UserPlus
  },
  setup() {
    const router = useRouter();
    const authStore = useAuthStore();

    const handleLogout = async () => {
      await authStore.logout();
      router.push('/');
    };

    return {
      authStore,
      handleLogout,
    };
  },
};
</script>
