# テストファイル解説

このドキュメントでは、プロジェクト内の各テストファイルの目的と内容について説明します。

## Feature Tests

### Auth Tests

#### AuthenticationTest.php
認証機能のテストです。

##### テストメソッド
- `test_login_screen_can_be_rendered`: ログイン画面が表示されることを確認
- `test_users_can_authenticate_using_the_login_screen`: ログインが正常に機能することを確認
- `test_users_can_not_authenticate_with_invalid_password`: 無効なパスワードでのログインが失敗することを確認
- `test_users_can_logout`: ログアウトが正常に機能することを確認
- `test_login_rate_limiting`: ログイン試行回数の制限が機能することを確認
- `test_login_validation`: ログインフォームのバリデーションが機能することを確認

#### EmailVerificationTest.php
メール認証機能のテストです。

##### テストメソッド
- `test_email_verification_screen_can_be_rendered`: メール認証画面が表示されることを確認
- `test_email_can_be_verified`: メール認証が正常に機能することを確認
- `test_email_is_not_verified_with_invalid_hash`: 無効なハッシュでの認証が失敗することを確認
- `test_can_resend_verification_email`: 認証メールの再送信が可能なことを確認
- `test_cannot_resend_verification_email_when_already_verified`: 既に認証済みの場合に再送信できないことを確認

#### LoginResponseTest.php
ログイン後のレスポンス処理のテストです。

##### テストメソッド
- `test_login_response_redirects_to_dashboard`: ログイン後にダッシュボードにリダイレクトされることを確認
- `test_login_response_redirects_to_intended_url`: 意図したURLがある場合、そこにリダイレクトされることを確認

#### FortifyServiceProviderTest.php
認証関連のサービスプロバイダーのテストです。

##### テストメソッド
- `test_login_response_is_bound`: ログインレスポンスが正しくバインドされていることを確認
- `test_login_view_is_registered`: ログインビューが登録されていることを確認
- `test_register_view_is_registered`: 登録ビューが登録されていることを確認
- `test_forgot_password_view_is_registered`: パスワード忘れビューが登録されていることを確認
- `test_reset_password_view_is_registered`: パスワードリセットビューが登録されていることを確認
- `test_verify_email_view_is_registered`: メール認証ビューが登録されていることを確認

#### VerifyEmailControllerTest.php
メール認証コントローラーのテストです。

##### テストメソッド
- `test_email_can_be_verified`: メール認証が正常に機能することを確認
- `test_email_is_not_verified_with_invalid_hash`: 無効なハッシュでの認証が失敗することを確認
- `test_guest_cannot_verify_email`: 未認証ユーザーが認証できないことを確認

#### EmailVerificationPromptControllerTest.php
メール認証プロンプトコントローラーのテストです。

##### テストメソッド
- `test_email_verification_screen_can_be_rendered`: 認証画面が表示されることを確認
- `test_verified_user_is_redirected_to_dashboard`: 認証済みユーザーがダッシュボードにリダイレクトされることを確認
- `test_guest_cannot_access_verification_screen`: 未認証ユーザーが認証画面にアクセスできないことを確認

#### PasswordResetTest.php
パスワードリセット機能のテストです。

##### テストメソッド
- `test_reset_password_link_screen_can_be_rendered`: リセットリンク画面が表示されることを確認
- `test_reset_password_link_can_be_requested`: リセットリンクのリクエストが可能なことを確認
- `test_reset_password_screen_can_be_rendered`: リセット画面が表示されることを確認
- `test_password_can_be_reset_with_valid_token`: 有効なトークンでパスワードがリセットできることを確認

#### PasswordConfirmationTest.php
パスワード確認機能のテストです。

##### テストメソッド
- `test_confirm_password_screen_can_be_rendered`: 確認画面が表示されることを確認
- `test_password_can_be_confirmed`: パスワード確認が正常に機能することを確認
- `test_password_is_not_confirmed_with_invalid_password`: 無効なパスワードでの確認が失敗することを確認

#### PasswordUpdateTest.php
パスワード更新機能のテストです。

##### テストメソッド
- `test_password_can_be_updated`: パスワードが更新できることを確認
- `test_correct_password_must_be_provided_to_update_password`: 現在のパスワードが必要なことを確認

#### RegistrationTest.php
ユーザー登録機能のテストです。

##### テストメソッド
- `test_registration_screen_can_be_rendered`: 登録画面が表示されることを確認
- `test_new_users_can_register`: 新規ユーザーが登録できることを確認

### ExpenseControllerTest.php
支出管理のコントローラーの機能テストです。

#### テストメソッド
- `test_show_returns_404_for_nonexistent_expense`: 存在しない支出の詳細表示時に404エラーが返されることを確認
- `test_store_fails_with_invalid_data`: 無効なデータでの支出登録が失敗することを確認
- `test_destroy_forbidden_for_other_user`: 他のユーザーの支出を削除できないことを確認
- `test_can_view_expense_edit_page`: 支出編集ページが正しく表示されることを確認
- `test_cannot_edit_other_users_expense`: 他のユーザーの支出を編集できないことを確認
- `test_can_update_expense`: 支出の更新が正しく行われることを確認
- `test_cannot_update_other_users_expense`: 他のユーザーの支出を更新できないことを確認
- `test_can_view_expense_details`: 支出詳細ページが正しく表示されることを確認
- `test_cannot_view_other_users_expense_details`: 他のユーザーの支出詳細を表示できないことを確認
- `test_can_view_expenses_list`: 支出一覧ページが正しく表示されることを確認
- `test_expenses_list_only_shows_own_expenses`: 自分の支出のみが一覧に表示されることを確認

### DashboardControllerTest.php
ダッシュボードの機能テストです。

#### テストメソッド
- `test_dashboard_requires_authentication`: 認証が必要なことを確認
- `test_dashboard_shows_monthly_total`: 月間合計が正しく表示されることを確認
- `test_dashboard_shows_zero_when_no_expenses`: 支出がない場合に0が表示されることを確認
- `test_dashboard_only_shows_own_expenses`: 自分の支出のみが集計されることを確認

### ExpenseReportControllerTest.php
支出レポートの機能テストです。

#### テストメソッド
- `test_report_requires_authentication`: 認証が必要なことを確認
- `test_report_shows_current_month_by_default`: デフォルトで現在の月のデータが表示されることを確認
- `test_report_shows_specified_month`: 指定した月のデータが表示されることを確認
- `test_report_shows_category_totals`: カテゴリー別の合計が正しく表示されることを確認
- `test_report_shows_monthly_totals_for_past_6_months`: 過去6ヶ月分の月次合計が表示されることを確認
- `test_report_only_shows_own_expenses`: 自分の支出のみが集計されることを確認

### ExpenseTest.php (Feature)
支出機能の統合テストです。

#### テストメソッド
- `test_can_view_expenses_list`: 支出一覧が表示できることを確認
- `test_can_create_expense`: 支出を作成できることを確認
- `test_can_delete_expense`: 支出を削除できることを確認
- `test_validates_required_fields`: 必須フィールドのバリデーションが機能することを確認

### ProfileTest.php
ユーザープロファイル機能のテストです。

#### テストメソッド
- `test_profile_page_is_displayed`: プロファイルページが表示されることを確認
- `test_profile_information_can_be_updated`: プロファイル情報が更新できることを確認
- `test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged`: メールアドレスが変更されない場合の検証状態の確認
- `test_user_can_delete_their_account`: アカウントを削除できることを確認
- `test_correct_password_must_be_provided_to_delete_account`: アカウント削除時に正しいパスワードが必要なことを確認

#### Fortify Tests

##### UpdateUserPasswordTest.php
ユーザーパスワード更新機能のテストです。

###### テストメソッド
- `test_password_can_be_updated`: パスワードが更新できることを確認
- `test_current_password_must_be_correct`: 現在のパスワードが正しい必要があることを確認
- `test_password_must_be_confirmed`: パスワードの確認が必要なことを確認
- `test_password_must_match_validation_rules`: パスワードがバリデーションルールに合致する必要があることを確認

##### ResetUserPasswordTest.php
ユーザーパスワードリセット機能のテストです。

###### テストメソッド
- `test_password_can_be_reset`: パスワードがリセットできることを確認
- `test_password_must_be_confirmed`: パスワードの確認が必要なことを確認
- `test_password_must_match_validation_rules`: パスワードがバリデーションルールに合致する必要があることを確認

##### PasswordValidationRulesTest.php
パスワードバリデーションルールのテストです。

###### テストメソッド
- `test_password_validation_rules`: パスワードバリデーションルールが正しく設定されていることを確認
- `test_password_validation`: パスワードバリデーションが正しく機能することを確認

##### UpdateUserProfileInformationTest.php
ユーザープロファイル情報更新機能のテストです。

###### テストメソッド
- `test_can_update_user_profile`: プロファイル情報が更新できることを確認
- `test_cannot_update_to_existing_email`: 既存のメールアドレスに更新できないことを確認
- `test_can_update_name_without_changing_email`: メールアドレスを変更せずに名前を更新できることを確認

##### CreateNewUserTest.php
新規ユーザー作成機能のテストです。

###### テストメソッド
- `test_can_create_new_user`: 新規ユーザーが作成できることを確認
- `test_cannot_create_user_with_existing_email`: 既存のメールアドレスでユーザーを作成できないことを確認
- `test_password_must_be_confirmed`: パスワードの確認が必要なことを確認

## Unit Tests

### Services Tests

#### ExpenseCalculationServiceTest.php
支出計算サービスの単体テストです。

##### テストメソッド
- `test_calculates_total_for_period`: 指定期間の支出合計が正しく計算されることを確認
- `test_calculates_total_by_category`: カテゴリー別の支出合計が正しく計算されることを確認
- `test_calculates_monthly_average`: 月平均支出が正しく計算されることを確認
- `test_returns_zero_for_no_expenses`: 支出がない場合に0が返されることを確認

### ExpenseTest.php (Unit)
支出モデルの単体テストです。

#### テストメソッド
- `test_expense_has_required_attributes`: 必須属性が定義されていることを確認
- `test_expense_amount_is_cast_to_integer`: 金額が整数に変換されることを確認
- `test_expense_date_is_cast_to_date`: 日付が正しく変換されることを確認
- `test_expense_can_be_created`: 支出が作成できることを確認
- `test_expense_belongs_to_user`: ユーザーとの関連付けが正しいことを確認
- `test_expense_category_must_be_valid`: カテゴリーのバリデーションが機能することを確認

### UserTest.php
ユーザーモデルの単体テストです。

#### テストメソッド
- `test_user_can_be_created`: ユーザーが作成できることを確認
- `test_user_can_have_expenses`: ユーザーが支出を持つことができることを確認
- `test_user_email_must_be_unique`: メールアドレスが一意であることを確認
- `test_user_password_is_hashed`: パスワードがハッシュ化されることを確認 