<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <chat-room-selection
          v-if="currentRoom.id"
          :rooms="chatRooms"
          :currentRoom="currentRoom"
          v-on:roomchanged="setRoom($event)"
        />
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <message-container :messages="messages" />
          <input-message :room="currentRoom" v-on:messagesent="getMessages" />
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
  import AppLayout from "@/Layouts/AppLayout";
  import MessageContainer from "./messageContainer.vue";
  import InputMessage from "./inputMessage.vue";
  import ChatRoomSelection from "./chatRoomSelection.vue";

  export default {
    components: {
      AppLayout,
      MessageContainer,
      InputMessage,
      ChatRoomSelection
    },

    data() {
      return {
        chatRooms: [],
        currentRoom: [],
        messages: []
      };
    },

    watch: {
      currentRoom: function(val, oldVal) {
        if (oldVal.id) {
          this.disconnect(oldVal);
        }
        this.connect();
      }
    },

    methods: {
      connect: function() {
        if (this.currentRoom.id) {
          let vm = this;
          vm.getMessages();

          Echo.private(`chat.${this.currentRoom.id}`).listen(
            ".new.message",
            e => {
              this.getMessages();
            }
          );
        }
      },

      myFunction: function() {
        console.log("myfunction");
      },

      disconnect: function(room) {
        Echo.leave("chat." + room.id);
      },

      getRooms: function() {
        axios
          .get("/chat/rooms")
          .then(res => {
            this.chatRooms = res.data;
            this.setRoom(res.data[0]);
          })
          .catch(error => {
            console.log(error);
          });
      },

      setRoom: function(room) {
        this.currentRoom = room;
      },

      getMessages: function() {
        axios
          .get("/chat/room/" + this.currentRoom.id + "/messages")
          .then(res => {
            this.messages = res.data;
          })
          .catch(error => {
            console.log(error);
          });
      }
    },

    created() {
      this.getRooms();
    }
  };
</script>
                
