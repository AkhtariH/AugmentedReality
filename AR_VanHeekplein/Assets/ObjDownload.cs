using UnityEngine;
using System.Collections;
using System.Collections.Generic;
using System.IO;
using System.Text;
using Dummiesman;
using UnityEngine.Android;
using UnityEditor;
using System.Threading.Tasks;
using System.Net.Http;
using Newtonsoft.Json;
using UnityEngine.UIElements;

public class ObjDownload : MonoBehaviour
{
    public ObjImporter objImporter;
    public GameObject emptyPrefabWithMeshRenderer;
    private Label errorLabel;
    private Button signUpButton;

    // Use this for initialization
    void Start()
    {
        var rootVisualElement = GetComponent<UIDocument>().rootVisualElement;
        errorLabel = rootVisualElement.Q<Label>("error-label");
        signUpButton = rootVisualElement.Q<Button>("sign-up");
        signUpButton.RegisterCallback<ClickEvent>(async ev => await test());
        Debug.Log("Started");


        //StartCoroutine(StartLocationService());
        //StartCoroutine(ImportObject());
    }

    private IEnumerator StartLocationService()
    {
        if (!Input.location.isEnabledByUser)
        {
            Debug.Log("User has not enabled location");
            yield break;
        }
        Input.location.Start();
        while (Input.location.status == LocationServiceStatus.Initializing)
        {
            yield return new WaitForSeconds(1);
        }
        if (Input.location.status == LocationServiceStatus.Failed)
        {
            Debug.Log("Unable to determine device location");
            yield break;
        }
        Debug.Log("Latitude : " + Input.location.lastData.latitude);
        Debug.Log("Longitude : " + Input.location.lastData.longitude);
        Debug.Log("Altitude : " + Input.location.lastData.altitude);
    }

    private async Task test()
    {
        using (var client = new HttpClient())
        {
            var response = await client.GetAsync("http://127.0.0.1:8002/api/artobjects");
            var contents = await response.Content.ReadAsStringAsync();
            APIResponse apiResponse = JsonConvert.DeserializeObject<APIResponse>(contents);
            
            if (apiResponse.success == true)
            {
                foreach(Data data in apiResponse.data)
                {
                    StartCoroutine(ImportObject(data));
                }
            }
            else
            {
                errorLabel.text = apiResponse.message;
                Debug.Log(apiResponse.message);
            }
        }
    }
    
    IEnumerator ImportObject(Data data)
    {


        WWW www = new WWW("http://127.0.0.1:8002/img/uploads/" + data.file_path);
        yield return www;
        
        string write_path = Application.dataPath + "/Objects/" + data.file_path;
        System.IO.File.WriteAllBytes(write_path, www.bytes);
        Debug.Log("Wrote to path");
     
        var loadedObj = new OBJLoader().Load(Application.dataPath + "/Objects/" + data.file_path);
        loadedObj.name = data.name;
        //Instantiate(loadedObj, new Vector3(0, 0, 0), Quaternion.identity);

    }
}

class APIResponse
{
    public bool success { get; set; }
    public List<Data> data { get; set; }
    public string message { get; set; }
}

class Data
{
    public int id { get; set; }
    public int user_id { get; set; }
    public string name { get; set; }
    public string description { get; set; }
    public string file_path { get; set; }
    public double longitude { get; set; }
    public double latitude { get; set; }
    public int floatingHeight { get; set; }
    public string created_At { get; set; }
    public string updated_at { get; set; }
}