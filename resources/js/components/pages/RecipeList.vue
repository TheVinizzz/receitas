<template>
  <div class="min-h-[calc(100vh-4rem)] bg-gray-50 py-8 px-4">
    <div class="max-w-7xl mx-auto">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-900 flex items-center space-x-3">
            <BookOpen :size="32" class="text-orange-600" />
            <span>Minhas Receitas</span>
          </h1>
          <p class="text-gray-600 mt-1">Gerencie e organize suas receitas</p>
        </div>
        
        <router-link 
          to="/recipes/create" 
          class="flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-orange-500 to-red-600 text-white rounded-xl hover:from-orange-600 hover:to-red-700 transition-all shadow-lg hover:shadow-xl font-semibold"
        >
          <Plus :size="20" />
          <span>Nova Receita</span>
        </router-link>
      </div>

      <div class="bg-white rounded-xl shadow-md p-4 mb-6">
        <div class="relative">
          <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <Search :size="20" class="text-gray-400" />
          </div>
          <input
            v-model="searchTerm"
            type="text"
            placeholder="Buscar receitas por nome, ingredientes ou modo de preparo..."
            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
            @input="handleSearch"
          >
        </div>
      </div>

      <div v-if="loading" class="flex justify-center items-center py-20">
        <Loader2 :size="40" class="animate-spin text-orange-600" />
      </div>

      <div v-else-if="recipes.length === 0" class="text-center py-20">
        <div class="flex justify-center mb-6">
          <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center">
            <ChefHat :size="40" class="text-gray-400" />
          </div>
        </div>
        <h3 class="text-xl font-semibold text-gray-700 mb-2">Nenhuma receita encontrada</h3>
        <p class="text-gray-500 mb-6">Comece criando sua primeira receita!</p>
        <router-link 
          to="/recipes/create" 
          class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-orange-500 to-red-600 text-white rounded-xl hover:from-orange-600 hover:to-red-700 transition-all shadow-lg hover:shadow-xl font-semibold"
        >
          <Plus :size="20" />
          <span>Criar Primeira Receita</span>
        </router-link>
      </div>

      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="recipe in recipes"
          :key="recipe.id"
          class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all border border-gray-100 overflow-hidden group"
        >
          <div class="p-6">
            <div class="flex items-start justify-between mb-4">
              <div class="flex-1">
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-orange-600 transition-colors">
                  {{ recipe.nome }}
                </h3>
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                  <Tag :size="16" class="text-orange-500" />
                  <span>{{ recipe.categoria?.nome || 'Sem categoria' }}</span>
                </div>
              </div>
            </div>

            <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
              <div class="flex items-center space-x-1">
                <Clock :size="16" class="text-orange-500" />
                <span>{{ recipe.tempo_preparo_minutos }} min</span>
              </div>
              <div class="flex items-center space-x-1">
                <Users :size="16" class="text-orange-500" />
                <span>{{ recipe.porcoes }} porções</span>
              </div>
            </div>

            <div class="flex gap-2">
              <router-link 
                :to="`/recipes/${recipe.id}`"
                class="flex-1 flex items-center justify-center space-x-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors font-medium"
              >
                <Eye :size="18" />
                <span>Ver</span>
              </router-link>
              
              <router-link 
                :to="`/recipes/${recipe.id}/edit`"
                class="flex items-center justify-center px-4 py-2 bg-orange-50 hover:bg-orange-100 text-orange-600 rounded-lg transition-colors"
              >
                <Pencil :size="18" />
              </router-link>
              
              <button
                @click="deleteRecipe(recipe.id)"
                class="flex items-center justify-center px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors"
              >
                <Trash2 :size="18" />
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { BookOpen, Plus, Search, Loader2, ChefHat, Tag, Clock, Users, Eye, Pencil, Trash2 } from 'lucide-vue-next';

export default {
  name: 'RecipeList',
  components: {
    BookOpen,
    Plus,
    Search,
    Loader2,
    ChefHat,
    Tag,
    Clock,
    Users,
    Eye,
    Pencil,
    Trash2
  },
  setup() {
    const router = useRouter();
    const recipes = ref([]);
    const searchTerm = ref('');
    const loading = ref(false);

    const fetchRecipes = async () => {
      loading.value = true;
      try {
        const response = await axios.get('/api/receitas');
        recipes.value = response.data;
      } catch (error) {
        console.error('Erro ao carregar receitas:', error);
      } finally {
        loading.value = false;
      }
    };

    const handleSearch = async () => {
      if (!searchTerm.value.trim()) {
        await fetchRecipes();
        return;
      }

      loading.value = true;
      try {
        const response = await axios.get(`/api/receitas/search/${searchTerm.value}`);
        recipes.value = response.data;
      } catch (error) {
        console.error('Erro ao buscar receitas:', error);
      } finally {
        loading.value = false;
      }
    };

    const deleteRecipe = async (id) => {
      if (!confirm('Tem certeza que deseja excluir esta receita?')) {
        return;
      }

      try {
        await axios.delete(`/api/receitas/${id}`);
        await fetchRecipes();
      } catch (error) {
        console.error('Erro ao excluir receita:', error);
      }
    };

    onMounted(() => {
      fetchRecipes();
    });

    return {
      recipes,
      searchTerm,
      loading,
      handleSearch,
      deleteRecipe,
    };
  },
};
</script>
