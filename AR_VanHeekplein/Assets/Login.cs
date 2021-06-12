using System.Collections;
using System.Collections.Generic;
using System.Net.Http;
using System.Text;
using UnityEngine;
using UnityEngine.UIElements;
using UnityEngine.SceneManagement;
using Newtonsoft.Json;
using System.Net.Http.Headers;

public class Login : MonoBehaviour
{
    private Label titleLabel;
    private TextField emailField;
    private TextField passwordField;
    private Button submitButton;
    private Button signUpButton;
    private Label errorLabel;

    private void Create()
    {

    }
    private void OnEnable()
    {

        var rootVisualElement = GetComponent<UIDocument>().rootVisualElement;

        titleLabel = rootVisualElement.Q<Label>("title-label");
        emailField = rootVisualElement.Q<TextField>("email");
        passwordField = rootVisualElement.Q<TextField>("password");
        submitButton = rootVisualElement.Q<Button>("submit");
        //signUpButton = rootVisualElement.Q<Button>("sign-up");
        errorLabel = rootVisualElement.Q<Label>("error-label");

        submitButton.RegisterCallback<ClickEvent>(async ev => await LoginUserAsync());
        //signUpButton.RegisterCallback<ClickEvent>(ev => GoToRegisterScene());
    }

    private void GoToRegisterScene()
    {
        SceneManager.LoadScene("SignUpScene");
    }

    private async System.Threading.Tasks.Task LoginUserAsync()
    {
        var values = new Dictionary<string, string>{
          { "Email", emailField.text },
          { "Password", passwordField.text },
        };

        var json = JsonConvert.SerializeObject(values, Formatting.Indented);

        var stringContent = new StringContent(json, Encoding.UTF8, "application/json");
        using (var client = new HttpClient())
        {
            client.DefaultRequestHeaders.Accept.Add(new MediaTypeWithQualityHeaderValue("application/json"));
            var response = await client.PostAsync(
                "http://172.20.10.4:3001/api/v1/avh/login",
                 stringContent);
            var contents = await response.Content.ReadAsStringAsync();
            Response loginResponse = JsonConvert.DeserializeObject<Response>(contents);

            if (loginResponse.code == 1)
            {
                SceneManager.LoadScene("SampleScene");
            } else
            {
                errorLabel.text = loginResponse.message;
            }
        }
    }

}

class Response
{
    public int code { get; set; }
    public string message { get; set; }
}