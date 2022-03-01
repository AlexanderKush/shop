<template>
    <div>
        Example component mounted
        <br>
        {{ name }}
        <br>
        <button v-on:click="counterPlus" class="btn btn-info">Click {{ counter }}</button>
        <br>
        <span v-if="counter < 10">Значение counter меньше 10</span>
        <span v-else-if="counter < 15">Значение counter меньше 15</span>
        <span v-else>Значение counter больше или равно 15</span>
        <br>
        <span v-show="counter < 10">Значение counter меньше 10</span>
        <br>
        <button @click="shopwPicture = !shopwPicture" class="btn btn-success">Переключатель</button>
        <br>
        <br>
        <img v-if="shopwPicture" src="https://e7.pngegg.com/pngimages/847/1019/png-clipart-desktop-display-resolution-desktop-environment-space-atmosphere-computer-thumbnail.png">
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 100px;">#</th>
                    <th>Категория</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(category, index) in categories" :key="category.id">
                    <td>{{ index + 1 }}</td>
                    <td><a :href="'/category/' + category.id">{{ category.name }} {{ category.id }}</a></td>
                </tr>
            </tbody>
        </table>
        <button @click="addCategory()" class="btn btn-primary">Добавить категорию</button>
        <br>
        <br>
        <a href="category/7">LINK!</a>
        <br>
        <br>
        {{ fullName }}
        <br>
        <br>
        <input v-model="inputText" @input="listenInput" class="form-control">
        <br>
        <br>
        <input v-model="name" class="form-control">
        <br>
        <br>
        <input v-model="text" class="form-control">
        <br>
        <br>
        {{ reversedText }}
        <br>
        {{ reverseText() }}
        <br>
        <br>
        <!-- <select v-model='selected' @change="selectChanged" class="form-control"> -->
        <select v-model='selected' class="form-control">
            <option :value='null' selected disabled>-- Выберите значение --</option>
            <option v-for="(option, index) in options" :value="option" :key='index'>
                {{ option }}
            </option>
        </select>
        <br>
        <button :disabled="!selected" class="btn" :class="buttonClass">Сохранить</button>
        <br>
        <br>
        <button @click="getData" class="btn btn-info">Получить данные</button>
        <br>
        <br>
        <table class="table table-bordered">
            <tbody>
                <tr v-for="user in users" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                </tr>
                <tr v-if="!users.length">
                    <td class="text-center" colspan="3">
                        <em>Данные пока не получены</em>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
  data() {
    return {
      users: [],
      selected: null,
      options: [1, 2, 3],
      text: "",
      inputText: "",
      name: "Alex",
      lastName: "Kush",
      counter: 0,
      shopwPicture: true,
      categories: [
        {
          id: 7,
          name: "Видеокарты",
        },
        {
          id: 8,
          name: "Процессоры",
        },
        {
          id: 9,
          name: "Жёсткие диски",
        },
      ],
    };
  },
  methods: {
    getData() {
        const params = {
            id: 1
        }
        /* axios.post('/api/test', params).then(response => { */
        axios.get('/api/test', {params}).then(response => {
            this.users = response.data
        })
    },
    /* selectChanged() {
        console.log(this.selected)
    }, */
    reverseText() {
      return this.text.split("").reverse().join();
    },
    listenInput() {
      console.log(this.inputText);
    },
    addCategory() {
      this.categories.push({
        id: 10,
        name: "Оперативная память",
      });
    },
    counterPlus() {
      this.counter += 1;
      console.log(this.counter);
    },
  },
  computed: {
    buttonClass() {
        return this.selected ? 'btn-success' : 'btn-primary'
    },
    fullName() {
      return this.name + " " + this.lastName;
    },
    reversedText() {
      return this.text.split("").reverse().join();
    },
  },
  watch: {
      selected: function (newValue, oldValue) {
          console.log('oldValue', oldValue)
          console.log('newValue', newValue)
      }
  },
  mounted() {
    console.log("Example component mounted.");
  },
};
</script>

<style scoped>
</style>