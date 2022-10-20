import moment from 'moment';

export default {
  methods: {
    getDaysInMonthArray(year, month) {
      let day_arr = [];
      let maxDays = moment(year + '-' + month, 'YYYY-MM').daysInMonth();

      for (let i = 1; i <= maxDays; i++) {
        i < 10 ? day_arr.push('0' + i) : day_arr.push(i.toString());
      }
      return day_arr;
    },
    pad(d) {
      return d < 10 ? '0' + d.toString() : d.toString();
    },

    getCountStudentsText(count) {
        switch(count.toString().slice(-1)) {
            case '1':
                return this.$t("declination.one_student");
            case '2':
            case '3':
            case '4':
                return this.$t("declination.two_student");
            default:
                return this.$t("declination.lot_students");
        }
    },

    toInputDateFormat(inputDate, type) {
        let date = this.convertStringToDateFormat(inputDate);
        let day = date.getDate() > 9 ? date.getDate() : '0' + date.getDate();
        let month = (date.getMonth() + 1) > 9 ? date.getMonth() + 1 : '0' + (date.getMonth() + 1);
        let year = date.getFullYear();
        let hour = date.getHours();
        let minutes = date.getMinutes();
        let formatTime = inputDate.indexOf(' ') > -1 ? inputDate.split(' ')[1] : hour + ':' + minutes;
        let formatDate = year + '-' + month + '-' + day;

        return type === 'time' ? formatTime : formatDate;
    },

      today() {
          let today = new Date();
          let dd = today.getDate();
          let mm = today.getMonth() + 1;
          let yyyy = today.getFullYear();

          if (dd < 10) {
              dd = '0' + dd;
          }

          if (mm < 10) {
              mm = '0' + mm;
          }

          return yyyy + '-' + mm + '-' + dd;
      },

      convertStringToDateFormat(inputDate) {
        if (inputDate.indexOf(' ') > -1) {
            let date = inputDate.split(' ')[0];
            let time = ' ' + inputDate.split(' ')[1];

            return new Date(date.split('.')[2], (date.split('.')[1] - 1), date.split('.')[0], time.split(':')[0], time.split(':')[1]);
        } else {
            let date = inputDate;

            return new Date(date.split('.')[2], (date.split('.')[1] - 1), date.split('.')[0]);
        }
      },

      whenWasDeadline(date) {
          let today = new Date();
          let diff = today - date;

          if (diff < 1000) {
              return this.$t("declination.now");
          }

          let sec = Math.floor(diff / 1000);

          if (sec < 60) {
              return sec + ' ' + this.$t("declination.seconds") + ' ' + this.$t("declination.ago");
          }

          let min = Math.floor(diff / 60000);
          if (min < 60) {
              return min + ' ' + this.$t("declination.minutes") + ' ' + this.$t("declination.ago");
          }

          let hour = Math.floor(diff / 3600000);
          if (hour < 24) {
              let text = this.$t("declination.lot_hours");
              switch(hour.toString().slice(-1)) {
                  case '1':
                      text = this.$t("declination.one_hour");
                      break;
                  case '2':
                  case '3':
                  case '4':
                      text = this.$t("declination.two_hours");
                      break;
              }

              return hour + ' ' + text + ' ' + this.$t("declination.ago");
          }

          let day = Math.floor(diff / 86400000);
          if (day < 30) {
              let text = this.$t("declination.lot_days");
              switch(day.toString().slice(-1)) {
                  case '1':
                      text = this.$t("declination.one_day");
                      break;
                  case '2':
                  case '3':
                  case '4':
                      text = this.$t("declination.two_days");
                      break;
              }

              return day + ' ' + text + ' ' + this.$t("declination.ago");
          }

          let mon = (today.getFullYear() - date.getFullYear() + 1) * 12;
          mon += date.getMonth();
          mon -= today.getMonth() + 1;

          if (mon < 12) {
              let text = this.$t("declination.lot_months");
              switch(mon.toString().slice(-1)) {
                  case '1':
                      text = this.$t("declination.one_month");
                      break;
                  case '2':
                  case '3':
                  case '4':
                      text = this.$t("declination.two_months");
                      break;
              }
              return mon + ' ' + text + ' ' + this.$t("declination.ago");
          }

          let year = today.getFullYear() - date.getFullYear();
          let text = this.$t("declination.lot_year");
          switch(year.toString().slice(-1)) {
              case '1':
                  text = this.$t("declination.one_year");
                  break;
              case '2':
              case '3':
              case '4':
                  text = this.$t("declination.two_year");
                  break;
          }
          return year + ' ' + text + ' ' + this.$t("declination.ago");
      }
  }
};
