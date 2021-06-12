using System.Collections;
using System.Collections.Generic;
using System.IO;
using System.Net;
using UnityEditor;
using UnityEngine;
using UnityEngine.Networking;
using UnityEngine.UIElements;

public class AdminPanel : MonoBehaviour
{
    string mainUrl = "http://localhost:3001/api/v1/avh/upload";
    string saveLocation;
    void Start()
    {
        saveLocation = @"/Users/hemranakhtari/Desktop/text-65FB56807E44-1.txt"; // The file path.
        StartCoroutine(Upload());
    }

    // Upload
    IEnumerator Upload()
    {
        // Create a form.
        WWWForm form = new WWWForm();
        byte[] imagebytes = File.ReadAllBytes(saveLocation);
        // Add the file.
        form.AddBinaryData("Login.txt", imagebytes, "Login.txt");

        // Send POST request.
        string url = mainUrl;
        WWW POSTZIP = new WWW(url, form);

        Debug.Log("Sending zip...");
        yield return POSTZIP;
        Debug.Log("Zip sent!");
    }
}
