# Unit Tests for Controllers

## Auth Controllers
- [x] AuthenticatedSessionControllerTest
  - [x] test_create_returns_login_view
  - [x] test_store_authenticates_and_redirects_based_on_role
  - [x] test_store_invalid_credentials
  - [x] test_destroy_logs_out_and_redirects

- [x] ConfirmablePasswordControllerTest
  - [x] test_show_returns_confirm_password_view
  - [x] test_store_confirms_password_and_redirects
  - [x] test_store_invalid_password_throws_validation_exception

- [x] EmailVerificationNotificationControllerTest
  - [x] test_store_sends_verification_when_unverified
  - [x] test_store_redirects_when_already_verified

- [x] EmailVerificationPromptControllerTest
  - [x] test_invoke_redirects_when_verified
  - [x] test_invoke_returns_verify_email_view_when_unverified

- [x] NewPasswordControllerTest
  - [x] test_create_returns_reset_password_view
  - [x] test_store_resets_password_successfully
  - [x] test_store_fails_with_invalid_token

- [x] PasswordControllerTest
  - [x] test_update_changes_password_successfully
  - [x] test_update_fails_with_wrong_current_password

- [x] PasswordResetLinkControllerTest
  - [x] test_create_returns_forgot_password_view
  - [x] test_store_sends_reset_link_successfully
  - [x] test_store_fails_with_invalid_email

- [x] RegisteredUserControllerTest
  - [x] test_create_returns_register_view
  - [x] test_store_creates_user_and_logs_in
  - [x] test_store_fails_with_duplicate_email

- [x] VerifyEmailControllerTest
  - [x] test_invoke_verifies_email_and_redirects
  - [x] test_invoke_redirects_when_already_verified

## ProfileController
- [x] ProfileControllerTest
  - [x] test_edit_returns_profile_edit_view
  - [x] test_update_updates_profile_successfully
  - [x] test_update_resets_email_verification_when_email_changed
  - [x] test_destroy_deletes_account_and_logs_out

## JurusanController
- [x] JurusanControllerTest
  - [x] test_kjfdSelection_returns_kjfd_view
  - [x] test_proposalsIndex_returns_proposals_with_filtering
  - [x] test_proposalsIndex_filters_by_nim
