using System.Collections;
using System.Collections.Generic;
using System.Net.Http;
using System.Text;
using UnityEngine;
using UnityEngine.UIElements;
using UnityEngine.SceneManagement;
using Newtonsoft.Json;
using System.Net.Http.Headers;

public class Register : MonoBehaviour
{
    private TextField nameField;
    private TextField emailField;
    private TextField passwordField;
    private TextField confirmPasswordField;
    private Button signUpButton;
    private Label errorLabel;
    
    private void OnEnable()
    {
        var rootVisualElement = GetComponent<UIDocument>().rootVisualElement;

        nameField = rootVisualElement.Q<TextField>("name");
        emailField = rootVisualElement.Q<TextField>("email");
        passwordField = rootVisualElement.Q<TextField>("password");
        confirmPasswordField = rootVisualElement.Q<TextField>("confirm-password");
        signUpButton = rootVisualElement.Q<Button>("sign-up-button");
        errorLabel = rootVisualElement.Q<Label>("error-label");

        signUpButton.RegisterCallback<ClickEvent>(async ev => await SignUpUserAsync());
    }

    private async System.Threading.Tasks.Task SignUpUserAsync()
    {
        if (nameField.text != "" && emailField.text != "" && passwordField.text != "" && confirmPasswordField.text != "")
        {
            if (passwordField.text == confirmPasswordField.text)
            {
                var values = new Dictionary<string, string>{
                  { "Name", nameField.text },
                  { "Email", emailField.text },
                  { "Password", passwordField.text },
                };

                var json = JsonConvert.SerializeObject(values, Formatting.Indented);

                var stringContent = new StringContent(json, Encoding.UTF8, "application/json");
                using (var client = new HttpClient())
                {
                    client.DefaultRequestHeaders.Accept.Add(new MediaTypeWithQualityHeaderValue("application/json"));
                    var response = await client.PostAsync(
                        "http://172.20.10.4:3001/api/v1/avh/register",
                         stringContent);
                    var contents = await response.Content.ReadAsStringAsync();
                    Response loginResponse = JsonConvert.DeserializeObject<Response>(contents);

                    if (loginResponse.code == 1)
                    {
                        SceneManager.LoadScene("SampleScene");
                    }
                    else
                    {
                        errorLabel.text = loginResponse.message;
                    }
                }
            } else
            {
                errorLabel.text = "Passwords don't match.";
            }
        } else
        {
            errorLabel.text = "Please fill in all required fields.";
        }
    }

}