using System.Collections;
using UnityEngine;
using UnityEngine.Networking;

public class PostSender : MonoBehaviour
{
    // API URL (Adjust IP if running on a real device/emulator)
    private string apiUrl = "http://127.0.0.1:8000/api/posts";

    public void SendPost()
    {
        StartCoroutine(PostCoroutine());
    }

    IEnumerator PostCoroutine()
    {
        // JSON Body
        string jsonBody = "{\"body\": \"Hello from Unity!\"}";
        byte[] bodyRaw = System.Text.Encoding.UTF8.GetBytes(jsonBody);

        // Create Request
        UnityWebRequest request = new UnityWebRequest(apiUrl, "POST");
        request.uploadHandler = new UploadHandlerRaw(bodyRaw);
        request.downloadHandler = new DownloadHandlerBuffer();
        
        // Headers
        request.SetRequestHeader("Content-Type", "application/json");
        request.SetRequestHeader("Accept", "application/json");

        // Send
        yield return request.SendWebRequest();

        if (request.result == UnityWebRequest.Result.Success)
        {
            Debug.Log("Success: " + request.downloadHandler.text);
        }
        else
        {
            Debug.LogError("Error: " + request.error);
            Debug.LogError("Response: " + request.downloadHandler.text);
        }
    }
}
