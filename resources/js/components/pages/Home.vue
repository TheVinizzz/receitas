<template>
  <div class="min-h-[calc(100vh-4rem)] bg-gradient-to-br from-orange-50 via-white to-red-50">
    <div class="max-w-6xl mx-auto px-4 py-20">
      <div class="text-center mb-16">
        <div class="flex justify-center mb-6">
          <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center shadow-2xl">
            <ChefHat :size="48" class="text-white" />
          </div>
        </div>
        
        <h1 class="text-5xl font-bold text-gray-900 mb-4">
          Bem-vindo ao
          <span class="bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">
            RecipeHub
          </span>
        </h1>
        
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
          Organize, gerencie e compartilhe suas receitas favoritas em um só lugar
        </p>
      </div>

      <div v-if="!isAuthenticated" class="flex justify-center gap-4 mb-20">
        <router-link 
          to="/login" 
          class="flex items-center space-x-2 px-8 py-4 bg-white text-gray-800 rounded-xl hover:bg-gray-50 transition-all shadow-lg hover:shadow-xl border border-gray-200 font-semibold"
        >
          <LogIn :size="24" />
          <span>Entrar</span>
        </router-link>
        
        <router-link 
          to="/register" 
          class="flex items-center space-x-2 px-8 py-4 bg-gradient-to-r from-orange-500 to-red-600 text-white rounded-xl hover:from-orange-600 hover:to-red-700 transition-all shadow-lg hover:shadow-xl font-semibold"
        >
          <UserPlus :size="24" />
          <span>Criar Conta</span>
        </router-link>
      </div>
      
      <div v-else class="flex justify-center mb-20">
        <router-link 
          to="/recipes" 
          class="flex items-center space-x-3 px-10 py-4 bg-gradient-to-r from-orange-500 to-red-600 text-white rounded-xl hover:from-orange-600 hover:to-red-700 transition-all shadow-lg hover:shadow-xl font-semibold text-lg"
        >
          <BookOpen :size="28" />
          <span>Ver Minhas Receitas</span>
          <ArrowRight :size="24" />
        </router-link>
      </div>

      <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow border border-gray-100">
          <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center mb-4">
            <BookOpen :size="28" class="text-white" />
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">Organize Receitas</h3>
          <p class="text-gray-600">
            Mantenha todas as suas receitas organizadas por categorias e facilmente acessíveis
          </p>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow border border-gray-100">
          <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center mb-4">
            <Search :size="28" class="text-white" />
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">Busca Rápida</h3>
          <p class="text-gray-600">
            Encontre qualquer receita instantaneamente através da busca inteligente
          </p>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow border border-gray-100">
          <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center mb-4">
            <Printer :size="28" class="text-white" />
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">Imprima e Cozinhe</h3>
          <p class="text-gray-600">
            Imprima suas receitas favoritas de forma organizada e prática para cozinhar
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { computed } from 'vue';
import { useAuthStore } from '../../stores/auth';
import { ChefHat, LogIn, UserPlus, BookOpen, ArrowRight, Search, Printer } from 'lucide-vue-next';

export default {
  name: 'Home',
  components: {
    ChefHat,
    LogIn,
    UserPlus,
    BookOpen,
    ArrowRight,
    Search,
    Printer
  },
  setup() {
    const authStore = useAuthStore();
    const isAuthenticated = computed(() => authStore.isAuthenticated);

    return {
      isAuthenticated,
    };
  },
};
</script>
