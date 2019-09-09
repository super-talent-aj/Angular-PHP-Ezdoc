import {Component, OnInit, AfterViewInit} from '@angular/core';
import {Profile} from "../../../models/profile";
import {ProfileService} from "../../../services/profile.service";
import {Router} from '@angular/router';
import {HeaderComponent} from "../../../pages/layout/header/header.component";
import {Notification} from "../../../common_modules/notification";
import {Common} from "../../../common";
import "../../../../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"

declare let $: any;
declare let bootbox: any;

@Component({
  selector: "app-profile",
  templateUrl: "./profile.component.html",
  styleUrls: [
    "./profile.component.css",
    "../../../../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"
  ],
  providers: [ProfileService]
})
export class ProfileComponent implements OnInit {
  static instance: ProfileComponent;

  constructor(
    private _profileService: ProfileService,
    private _router: Router
  ) {
    ProfileComponent.instance = this;
  }

  lawfirm_name: string;
  email: string;
  profile: Profile;
  private errorMessage: string;
  private avatarEnabled: boolean;
  current_password: string;
  new_password: string;
  confirm_password: string;
  user;
  avatarExist = false;
  fullName = "";
  avatarBackground = "#5b00ff";

  ngOnInit() {
    Common.showLoading();

    this._profileService.getMyProfile().subscribe(
      profile => {
        Common.hideLoading();

        this.profile = profile;
        this.avatarExist = profile.avatar.indexOf("avatar.png") < 0;
        this.fullName = profile.first_name + " " + profile.last_name;
        this.avatarBackground = Common.stringToHslColor(this.fullName);
        this.email = profile.user["email"];
        this.lawfirm_name = profile.lawfirm["name"];
      },
      error => (this.errorMessage = <any>error)
    );

    this.user = Common.getUser();
  }

  onSubmit(saveProfileForm) {
    Common.confirm("Are you sure you want to change this profile?", function() {
      ProfileComponent.instance._profileService
        .saveProfile(ProfileComponent.instance.profile)
        .subscribe(response => {
          console.log(response);
          Notification.notifyAny({ message: response.success.message });
          HeaderComponent.instance.refreshProfile();
        });
    });
  }

  onChangePassword(changePasswordForm) {
    if (this.new_password != this.confirm_password) {
      Notification.notifyAny({
        message: "Please retype the confirm password exactly.",
        type: "error"
      });
      $("#confirmPasswordInput").focus();
      return;
    }
    if (this.new_password.length < 6) {
      Notification.notifyAny({
        message: "Please enter at least 6 letters.",
        type: "error"
      });
      return;
    }
    this._profileService
      .changePassword(
        this.current_password,
        this.new_password,
        this.profile.user_id
      )
      .subscribe(response => {
        Notification.notifyAny({ message: response.success.message });
      });
  }

  ngAfterViewInit() {
    // Avatar upload
    $("#avatarFile").change(function() {
      let file = this.files[0];
      if (file == null) {
        TurnFileWarning("Choose avatar file.", true);
        TurnUpload(false);
        return;
      }

      if (file.name.length < 1) {
      } else if (
        file.type != "image/png" &&
        file.type != "image/jpg" &&
        file.type != "image/gif" &&
        file.type != "image/jpeg"
      ) {
        TurnFileWarning("File type is wrong.", true);
        TurnUpload(false);
      } else if (file.size > 500000) {
        TurnFileWarning("File size is exceed.", true);
        TurnUpload(false);
      } else {
        TurnFileWarning("", false);
        TurnUpload(true);
      }
    });

    function TurnUpload(on) {
      ProfileComponent.instance.avatarEnabled = on;

      if (on == true) {
        $("#upload_file").show();
      } else {
        $("#upload_file").hide();
      }
    }

    function TurnFileWarning(message, on) {
      if (on == true) {
        $("#file_warning").show();
      } else {
        $("#file_warning").hide();
      }
      $("#file_message").text(message, true);
    }
  }

  onAptTypeChanged(event, type) {
    event.preventDefault();
    
    this.profile.apartment = false;
    this.profile.suite = false;
    this.profile.floor = false;

    if (type == 'apartment') {
      this.profile.apartment = true;
    } else if (type == 'suite') {
      this.profile.suite = true;
    } else {
      this.profile.floor = true;
    }
  }

  onSubmitAvatar(avatarForm) {
    if (!this.avatarEnabled) {
      return;
    }

    let file = $("#avatarFile")[0].files[0];
    if (file != null) {
      let avatar = file.result;
      let id = this.profile.id;
      this._profileService.changeAvatar(id, avatar).subscribe(
        response => {
          Notification.notifyAny({ message: "Avatar changed." });
          HeaderComponent.instance.refreshProfile();
        },
        error => {
          Notification.notifyAny({ message: "Changing avatar is failed." });
        }
      );
    }
  }
}
