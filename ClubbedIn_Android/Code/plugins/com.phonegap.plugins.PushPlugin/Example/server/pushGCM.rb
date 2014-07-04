require 'rubygems'
require 'pushmeup'
GCM.host = 'https://android.googleapis.com/gcm/send'
GCM.format = :json
GCM.key = "AIzaSyCgWcsMsAJ1grqvzVJOtMdz5fxSISwyxgM"
destination = ["APA91bEVaS2BsEpVfwOg6j1KKXk_q1XbCk-CyMcJRQzBLv6qJ_PU8EATxoT4lrlDleL3gQi0Qll2AjXumwEd1OeTBT9V4xDQiwK0l0zT5XWU_m9Q1jF0oAri1ZlqwBolN3qm4TUMAfvz7W7NhVVpO0Bx6ZcNbw5JlMgUNgOx73lUP6ii3ySXeqQ"]
data = {:message => "Clubbed In Rocks!", :msgcnt => "1", :soundname => "beep.wav"}

GCM.send_notification( destination, data)
