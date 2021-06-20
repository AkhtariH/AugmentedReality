using System.Collections;
using System.Collections.Generic;
using System.IO;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;
using ARLocation;
using Dummiesman;
using Newtonsoft.Json;
using UnityEngine;
using UnityEngine.Networking;
using UnityEngine.XR.ARFoundation;
using UnityEngine.XR.ARSubsystems;

public class test : MonoBehaviour
{

    private GameObject arObjectToSpawn;
    public GameObject placementIndicator;
    private GameObject spawnedObject;
    private Pose PlacementPose;
    private ARRaycastManager aRRaycastManager;
    private bool placementPoseIsValid = false;

    void Start()
    {
        aRRaycastManager = FindObjectOfType<ARRaycastManager>();
        tesst();
    }

    async void tesst()
    {
        Debug.Log("Starting Tesst");
        await Run();
    }

    // need to update placement indicator, placement pose and spawn 
    void Update()
    {
        if (spawnedObject == null && placementPoseIsValid && Input.touchCount > 0 && Input.GetTouch(0).phase == TouchPhase.Began)
        {
            ARPlaceObject();
        }


        //UpdatePlacementPose();
        //UpdatePlacementIndicator();




    }
    //void UpdatePlacementIndicator()
    //{
    //    if (spawnedObject == null && placementPoseIsValid)
    //    {
    //        placementIndicator.SetActive(true);
    //        placementIndicator.transform.SetPositionAndRotation(PlacementPose.position, PlacementPose.rotation);
    //    }
    //    else
    //    {
    //        placementIndicator.SetActive(false);
    //    }
    //}

    //void UpdatePlacementPose()
    //{
    //    var screenCenter = Camera.current.ViewportToScreenPoint(new Vector3(0.5f, 0.5f));
    //    var hits = new List<ARRaycastHit>();
    //    aRRaycastManager.Raycast(screenCenter, hits, TrackableType.Planes);

    //    placementPoseIsValid = hits.Count > 0;
    //    if (placementPoseIsValid)
    //    {
    //        PlacementPose = hits[0].pose;
    //    }
    //}

    void ARPlaceObject()
    {
        spawnedObject = Instantiate(arObjectToSpawn, PlacementPose.position, PlacementPose.rotation);
        var loc = new Location()
        {
            Latitude = 53.227060665274415,
            Longitude = 6.559411701442516,
            Altitude = 0,
            AltitudeMode = AltitudeMode.DeviceRelative
        };

        var opts = new PlaceAtLocation.PlaceAtOptions()
        {
            HideObjectUntilItIsPlaced = true,
            MaxNumberOfLocationUpdates = 2,
            MovementSmoothing = 0.5f,
            UseMovingAverage = false
        };

        PlaceAtLocation.AddPlaceAtComponent(arObjectToSpawn, loc, opts);
    }

    private async Task Run()
    {
        using (var client = new HttpClient())
        {
            var response = await client.GetAsync("http://20.52.187.225:8000/api/artobjects");
            var contents = await response.Content.ReadAsStringAsync();
            APIResponse apiResponse = JsonConvert.DeserializeObject<APIResponse>(contents);

            if (apiResponse.success == true)
            {
                foreach (Data data in apiResponse.data)
                {
                    StartCoroutine(ImportObject(data));
                }
            }
            else
            {
                Debug.Log(apiResponse.message);
            }
        }
        Debug.Log("CLA");
        Debug.Log(arObjectToSpawn);
    }

    IEnumerator ImportObject(Data data)
    {
        Debug.Log(data.file_path);
        string url = "http://20.52.187.225:8000/img/uploads/" + data.file_path;
        WWW www = new WWW(url);
        yield return www;

        while (!www.isDone)
            System.Threading.Thread.Sleep(1);

        var textStream = new MemoryStream(Encoding.UTF8.GetBytes(www.text));
        var loadedObj = new OBJLoader().Load(textStream);
        
        arObjectToSpawn = loadedObj;
        //var loc = new Location()
        //{
        //    Latitude = 53.227060665274415,
        //    Longitude = 6.559411701442516,
        //    Altitude = 0,
        //    AltitudeMode = AltitudeMode.GroundRelative
        //};

        //var opts = new PlaceAtLocation.PlaceAtOptions()
        //{
        //    HideObjectUntilItIsPlaced = true,
        //    MaxNumberOfLocationUpdates = 2,
        //    MovementSmoothing = 0.5f,
        //    UseMovingAverage = false
        //};

        //PlaceAtLocation.AddPlaceAtComponent(loadedObj, loc, opts);
    }
}